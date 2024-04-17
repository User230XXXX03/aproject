<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{


    /**
     * User cancel account api
     */
    public function cancel()
    {
        $result = [
            'status' => 'success',
            'message' => 'Operation successful',
            'data' => [
            ],
        ];
        // Open transaction
        DB::beginTransaction();
        try {
            $user = session('user');
            // delete user projects
            DB::table('projects')->where('uid', $user['uid'])->delete();
            // delete user account
            $res = DB::table('users')->where('uid', $user['uid'])->delete();
            // delete successful
            if ($res) {
                //logout
                session()->forget('user');
//                auth()->logout();
                DB::commit();
                return response()->json($result, 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $result['data'] = $e->getMessage();
        }

        $result['status'] = 'error';
        $result['message'] = 'Operation failed';
        return response()->json($result, 200);
    }
}
