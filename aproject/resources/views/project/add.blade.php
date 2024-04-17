<!-- resources/views/register.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container" style="width: 700px">
        <div class="row">
            <div class="col-md-12 col-md-offset-12">
                <p>
                    @if ($errors->has('message'))
                        <span class="help-block">
                            <strong>{{ $errors->first('message') }}</strong>
                        </span>
                    @endif
                </p>
                <div class="panel panel-default">
                    <div class="panel-heading" style="text-align: center;padding: 20px 0">Add Project</div>
                    <div class="panel-body">
                        <form method="POST" action="{{ $id>0?asset("add").'/'.$id:url('add') }}">
                            @csrf
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title">Title</label>
                                <input id="title" type="text" class="form-control" name="title"
                                       value="{{ old('title')??$project['title']??'' }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                                <label for="email">Start date</label>
                                <input id="start_date" class="form-control" name="start_date"
                                       value="{{ old('start_date')??$project['start_date']??'' }}" required>

                                @if ($errors->has('start_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                                <label for="end_date">End date</label>
                                <input id="end_date" class="form-control" name="end_date" value="{{ old('end_date')??$project['end_date']??'' }}" required>

                                @if ($errors->has('end_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('end_date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('phase') ? ' has-error' : '' }}">
                                <label for="phase">Phase</label>
                                <select id="phase" name="phase" required class="form-control">
                                    <option value="design" {{ (old('phase')??$project['phase']??'')=='design' ? 'selected' : '' }}>design</option>
                                    <option value="development" {{ (old('phase')??$project['phase']??'')=='development' ? 'selected' : '' }}>development</option>
                                    <option value="testing" {{ (old('phase')??$project['phase']??'')=='testing' ? 'selected' : '' }}>testing</option>
                                    <option value="deployment" {{ (old('phase')??$project['phase']??'')=='deployment' ? 'selected' : '' }}>deployment</option>
                                    <option value="complete" {{ (old('phase')??$project['phase']??'')=='complete' ? 'selected' : '' }}>complete</option>
                                </select>
                                @if ($errors->has('phase'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phase') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description">Description</label>
                                <textarea id="description" class="form-control" rows="6" maxlength="255" name="description" aria-label="With textarea">{{ old('description')??$project['description']??'' }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{ $id>0 ? 'save' : 'add' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .help-block{
            color: red;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('#start_date').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#end_date').datepicker({
                format: 'yyyy-mm-dd'
            });
        });

    </script>
@endsection
