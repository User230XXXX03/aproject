{{-- Project List template login.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="get" id="searchForm" action="/">
            @csrf
            <div class="row" style="width: 100%">
                <div class="col-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Title</span>
                        </div>
                        <input type="text" name="title" value="{{ $title??'' }}" class="form-control" id="basic-url"
                               aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="col-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Date</span>
                        </div>
                        <input name="start_date" value="{{ $start_date??'' }}" id="datepicker" class="form-control">
                    </div>
                </div>
                <div class="col-4">
                    <button class="btn btn-primary">Search</button>
                    <button type="button" class="btn btn-secondary" id="reset">Reset</button>
                </div>
            </div>
        </form>
        @if(session('user'))
            <div class="btn-group" role="group" aria-label="Basic example" style="margin-top: 20px">
                <a type="button" class="btn btn-success btn-sm" href="/add">Add+</a>
            </div>
        @endif

        <div class="table-bordered" style="margin-top: 10px;border: none">
            <table class="table">
                <thead>
                <tr>
                    <th>title</th>
                    <th>start date</th>
                    <th>description</th>
                    <th>operate</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td class="td-title">{{$project->title}}</td>
                        <td>{{$project->start_date}}</td>
                        <td class="td-description">{{$project->description}}</td>
                        <td>
                            <a href="{{ asset('details').'/'.$project->pid }}" class="btn btn-primary btn-sm">details</a>
                            @if(session('user'))
                                @if (session('user')->uid==$project->uid)
                                    <a href="{{ asset('add').'/'.$project->pid }}" class="btn btn-warning btn-sm">edit</a>
                                    <button type="button" data-id="{{$project->pid}}" class="btn btn-danger btn-sm del-project">del</button>
                                @endif

                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <div>{{ $projects->links() }}</div>
        </div>
    </div>
    <style>
        .td-title{
            width:20%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .td-description{
            width:50%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $("#reset").click(function () {
                location.href = '/'
            });
            $(".del-project").click(function () {
                let id = $(this).data('id');
                if(confirm('Are you sure you want to delete this project? Once deleted, it cannot be restored!!!')){
                    $.get("{{ asset('delete').'/' }}"+id,function (res) {
                        if(res.status==='success'){
                            alert("Operation successful");
                            location.reload()
                        }else{
                            alert(res.message);
                        }
                    })
                }

            });
        });

    </script>
@endsection
