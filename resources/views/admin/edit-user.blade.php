@extends('layout.manage')
@section('content')
    <div class="center-single-div pt-3 pb-3">
        <div class="container col-md-6 bg-light rounded">
            <form class="form-group" method="POST" action="{{route('edit-user')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <h2 class="text-center">Edit User</h2>
                <div class="input-group p-2">
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" name="name" value="{{$user->name}}"   placeholder="Fullname">
                </div>
                {!! $errors->first('name', '<span class="text-danger pl-2 text-danger-size">:message</span>') !!}
                <div class="input-group p-2">
                    <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : ''}}" name="email" value="{{$user->email}}" placeholder="Email">
                </div>
                {!! $errors->first('email', '<span class="text-danger pl-2 text-danger-size">:message</span>') !!}
                <div class="input-group p-2">
                    <select class="form-control" name="role">
                        @if ($user->role == 'Admin')
                            <option value="Admin" selected>Admin</option>
                            <option value="Member">Member</option>
                        @else
                            <option value="Admin">Admin</option>
                            <option value="Member"selected>Member</option>
                        @endif
                    </select>
                </div>
                {!! $errors->first('role', '<span class="text-danger pl-2 text-danger-size">:message</span>') !!}
                <div class="input-group p-2">
                    <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : ''}}" name="password" placeholder="Password">
                </div>
                <div class="input-group p-2">
                    <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : ''}}" name="password_confirmation" placeholder="Confirm Password">
                </div>
                {!! $errors->first('password', '<span class="text-danger pl-2 text-danger-size">:message</span>') !!}
                <div class="input-group p-2">
                    <div class="form-check form-check-inline">
                        @if ($user->gender == 'Male')
                            <input class="form-check-input" type="radio" value="Male" name="gender" id="genderMale" value="option1" checked>
                        @else
                        <input class="form-check-input" type="radio" value="Male" name="gender" id="genderMale" value="option1">
                        @endif
                        <label class="form-check-label" for="genderMale">
                            Male
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        @if ($user->gender == 'Female')
                            <input class="form-check-input" type="radio" value="Female" name="gender" id="genderFemale" value="option1" checked>
                        @else
                        <input class="form-check-input" type="radio" value="Female" name="gender" id="genderFemale" value="option1">
                        @endif
                        <label class="form-check-label" for="genderFemale">
                            Female
                        </label>
                    </div>
                </div>
                <div class="input-group p-2">
                    <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : ''}}" placeholder="{{$user->address}}" name="address" rows="3">{{$user->address}}</textarea>
                </div>
                {!! $errors->first('address', '<span class="text-danger pl-2 text-danger-size">:message</span>') !!}
                <div class="input-group p-2">
                    <input type="text" class="form-control {{ $errors->has('birthday') ? 'is-invalid' : ''}}" value="{{$user->birthday}}" name="birthday" placeholder="Date">
                </div>
                {!! $errors->first('birthday', '<span class="text-danger pl-2 text-danger-size">:message</span>') !!}
                <div class="input-group p-2">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input {{ $errors->has('profile_picture') ? 'is-invalid' : ''}}" name="profile_picture"  id="customFile">
                        <label class="custom-file-label" for="customFile" id="customFileLabel">Choose file</label>
                    </div>
                </div>
                {!! $errors->first('profile_picture', '<span class="text-danger pl-2 text-danger-size">:message</span>') !!}
                <input type="hidden" value="{{$user->id}}" name="id">
                <div class="input-group p-2">
                    <input type="submit" class="btn btn-danger login-btn btn-block">
                </div>
            </form>
        </div>
    </div>

    <script>
        var customFileInput = document.getElementById('customFile');
        customFileInput.onchange = function(){
            var fullPath = document.getElementById('customFile').value;
            if (fullPath) {
                var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                var filename = fullPath.substring(startIndex);
                if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                    filename = filename.substring(1);
                }
                document.getElementById('customFileLabel').innerHTML = filename;
            }
        }
    </script>
@endsection