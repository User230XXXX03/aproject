{{-- Project List template login.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="table-bordered" style="border: none;width: 700px;margin:10px auto 0">
            <table class="table">
                <thead>
                <th colspan="2" style="text-align: center">Project Details</th>
                </thead>
                <tbody>
                    <tr>
                        <th width="20%">Title</th>
                        <td>{{$project['title']??''}}</td>
                    </tr>
                    <tr>
                        <th>Phase</th>
                        <td>{{$project['phase']??''}}</td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <td>{{$project['end_date']??''}}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{$project['description']??''}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <style>
        .td-title{
            width:20%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .td-description{
            width:55%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
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
        });

    </script>
@endsection
