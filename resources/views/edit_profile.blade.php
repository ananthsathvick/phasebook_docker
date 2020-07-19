@extends('pro_layout')

@section('con')
<div class="container mt-3">
    <div class="row">
        <div class="col-11">
            <div class="card">
                <div class="card-body">
                    <form action="/update_profile">
                        @csrf
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-5">
                                    <label for="bio_id">Bio</label>
                                    <textarea type="text" class="form-control" id="bio_id" aria-describedby="bio_help" name="bio">{{$user->bio}}</textarea>
                                    <small id="bio_help" class="form-text text-muted">A short bio of yourself</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-5">
                                    <label for="work_id">Work</label>
                                    <input type="text" class="form-control" id="work_id" aria-describedby="work_help" name="work" value="{{$user->work}}">
                                    <small id="work_help" class="form-text text-muted">Describe your work place so others can connect</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-5">
                                    <label for="study_id">Study</label>
                                    <input type="text" class="form-control" id="study_id" aria-describedby="study_help" name="study" value="{{$user->study}}">
                                    <small id="study_help" class="form-text text-muted">Educational Background</small>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection