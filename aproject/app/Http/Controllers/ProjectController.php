<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
     * project list
     */
    public function index(Request $request)
    {
		
        $title = $request->get('title', '');              //project title
        $start_date = $request->get('start_date', '');    //project start date
        $where = [];
        //If the project title exists, use it as a condition
        if ($title != '') {
            $where[] = ['title', 'like', "%{$title}%"];
        }
        //If the date exists, use it as a condition
        if ($start_date != '') {
            $where[] = ['start_date', '=', "{$start_date}"];
        }
        //Query data
        $list = Projects::where($where)->orderBy('pid', 'desc')->paginate(8);
        return view("project.index", ['projects' => $list, 'title' => $title, 'start_date' => $start_date]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'phase' => ['required', Rule::in(['design', 'development', 'testing', 'deployment', 'complete'])],
            'description' => ['required', 'max:255']
        ]);
    }

    /**
     * Add project
     */
    public function add(Request $request, int $id = 0)
    {

        $params = $request->post();
        //Verify if the form is submitted
        if ($params) {
            //Verify the content of the form
            $validator = $this->validator($params);
            //Verification failed
            if ($validator->fails()) {
                return redirect('/add')
                    ->withErrors($validator)
                    ->withInput();
            }

            // get user info
            $auth = session('user');

            //Assembly inbound data
            $data = [
                'title' => $params['title'],
                'start_date' => $params['start_date'],
                'end_date' => $params['end_date'],
                'phase' => $params['phase'],
                'description' => htmlspecialchars($params['description']),//Convert predefined HTML tags into entity symbols to prevent injection
            ];

            //If the id is greater than 0, it is edited; otherwise, it is added
            if ($id > 0) {
                //Execute editing commands
                $result = Projects::where([['uid', '=', $auth['uid']], ['pid', '=', $id]])->update($data);
            } else {
                $data['uid'] = $auth['uid'];
                //Execute insert commands
                $result = Projects::insert($data);
            }
            if (!$result) {
                //Insertion failed with error message returned
                return redirect()->back()->withErrors(['message' => 'Operate failed.']);
            }
            //Insert successful, return to homepage
            return redirect()->intended('/')->with('success', 'Operate successful, return to homepage.');

        }
        $project = [];
        //When editing, it is necessary to obtain project details
        if ($id > 0) {
            $project = Projects::where('pid', $id)->first()->toArray();
        }

        return view('project.add', ['project' => $project, 'id' => $id]);
    }

    /**
     * get projects details
     */
    public function details(int $id = 0)
    {
        //Verify if the project ID has been passed over
        if ($id == 0) {
            return redirect()->back()->withErrors(['message' => 'Operate failed.']);
        }
        //Obtain project information and associate it to obtain user information
        $project = Projects::select('projects.*', 'users.email')->where('projects.pid', $id)
            ->join('users', function ($join) {
                $join->on('users.uid', '=', 'projects.uid');
            })
            ->first()->toArray();

        return view('project.details', ['project' => $project]);
    }

    /**
     * Delete project through project ID
     */
    public function delete(int $id = 0)
    {
        // Build processing results
        $result = [
            'status' => 'success',
            'message' => 'Operation successful',
            'data' => [
            ],
        ];

        //Verify if the project ID has been passed over
        if ($id == 0) {
            $result['status'] = 'error';
            $result['message'] = 'Please confirm the deletion of the target first';
            return response()->json($result, 200);
        }

        //Obtain project details to verify if the user has the permission to delete
        $project = Projects::where('pid', $id)->first()->toArray();
        $user = session('user');
        //authentication
        if ($project['uid'] != $user['uid']) {
            $result['status'] = 'error';
            $result['message'] = 'You are not authorized to take action';
            // Return JSON response
            return response()->json($result, 200);
        }
        // Delete Data;
        $res = Projects::where('pid', $id)->delete();
        if ($res) {
            return response()->json($result, 200);
        }

        $result['status'] = 'error';
        $result['message'] = 'Operation failed';
        return response()->json($result, 200);
    }
}
