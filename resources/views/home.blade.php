@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile Information</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="post" action="{{route('users.updateProfile', $user->id)}}" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">

                            <label for="name">Name:</label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" />
                        </div>

                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" name="username" value="{{ $user->username }}" />
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control" name="email" value="{{ $user->email }}" />
                        </div>

                        <div class="form-group">
                            <label for="nationalid">NationalId:</label>
                            <input type="text" class="form-control" name="nationalid" value="{{ $user->nationalid }}" />
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" class="form-control" name="phone" value="{{ $user->phone }}" />
                        </div>

                        <div>
                            <label>Update Profile Image</label>
                            <input type="file" name="user_image">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="pull-right btn btn-sm btn-primary">
                        </div>
                    </form>

                    <form action="{{ route('users.changePassword') }}">
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



