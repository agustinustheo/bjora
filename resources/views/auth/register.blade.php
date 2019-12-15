@extends('layout.application')
@section('content')
    <div class="center-single-div pt-3 pb-3">
        <div class="container col-md-6 bg-light rounded">
            <form class="form-group" method="POST" action="/register" enctype="multipart/form-data">
                {{ csrf_field() }}
                <h2 class="text-center">Register</h2>
                @if ($errors->any())
                    <div>
                        {{ implode('', $errors->all(':message')) }}
                    </div>
                @endif
                <div class="input-group p-2">
                    <input type="text" class="form-control" name="name" placeholder="Fullname">
                </div>
                <div class="input-group p-2">
                    <input type="text" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="input-group p-2">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <div class="input-group p-2">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                </div>
                <div class="input-group p-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="1" name="gender" id="genderMale" value="option1" checked>
                        <label class="form-check-label" for="genderMale">
                            Male
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="2" name="gender" id="genderFemale" value="option1">
                        <label class="form-check-label" for="genderFemale">
                            Female
                        </label>
                    </div>
                </div>
                <div class="input-group p-2">
                    <textarea class="form-control" placeholder="Address" name="address" rows="3"></textarea>
                </div>
                <div class="input-group p-2">
                    <input type="text" class="form-control" name="birthday" placeholder="Date">
                </div>
                <div class="input-group p-2">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="profile_picture"  id="customFile">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <div class="input-group p-2">
                    <input type="submit" class="btn btn-danger login-btn btn-block">
                </div>
            </form>
        </div>
    </div>
@endsection