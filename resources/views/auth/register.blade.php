@extends('layout.application')
@section('content')
    <div class="center-single-div pt-3 pb-3">
        <div class="container col-md-6 bg-light rounded">
            <form class="form-group">
                <h2 class="text-center">Register</h2>
                <div class="input-group p-2">
                    <input type="text" class="form-control" placeholder="Fullname">
                </div>
                <div class="input-group p-2">
                    <input type="text" class="form-control" placeholder="Email">
                </div>
                <div class="input-group p-2">
                    <input type="password" class="form-control" placeholder="Password">
                </div>
                <div class="input-group p-2">
                    <input type="password" class="form-control" placeholder="Confirm Password">
                </div>
                <div class="input-group p-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="genderMale" value="option1" checked>
                        <label class="form-check-label" for="genderMale">
                            Male
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="option1">
                        <label class="form-check-label" for="genderFemale">
                            Female
                        </label>
                    </div>
                </div>
                <div class="input-group p-2">
                    <textarea class="form-control" placeholder="Address" rows="3"></textarea>
                </div>
                <div class="input-group p-2">
                    <input type="text" class="form-control" placeholder="Date">
                </div>
                <div class="input-group p-2">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile">
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