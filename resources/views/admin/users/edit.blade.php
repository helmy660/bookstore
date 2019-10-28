@extends('layouts.admin.nav')

@section('content')
<div class="row">
 <div class="col-sm-8 offset-sm-2">

    <h1 class="display-6">Edit User " {{$user->name}} "</h1>
  <div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('users.update',$user->id)}}">
        @method('PATCH') 
          @csrf
          <div class="form-group">    
              <label for="name">Name:</label>
              <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}"/>
          </div>

          <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" name="email" value="{{ old('email',$user->email) }}"/>
          </div>

          <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" class="form-control" name="username" value="{{ old('username', $user->username) }}"/>
          </div>

          <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" name="password" value="{{ old('password','') }}" />
          </div>

          <div class="form-group">
              <label for="nationalid">NationalID:</label><br />
              <input  class="form-control" type="text"  name="nationalid" value="{{ old('nationalid', $user->nationalid) }}"/>
          </div>
          <div class="form-group">
              <label for="phone">Phone:</label><br />
              <input  class="form-control" type="tel"  name="phone" value="{{ old('phone', $user->phone) }}"/>
          </div>

          <div class="form-group">
              <label for="isactive">Active status:</label><br />
              <input  class="form-control" type="number" min="0" max="1" size="1" name="isactive" value="{{ old('isactive', $user->isactive) }}"/>
          </div>
                      
          <button type="submit" class="btn btn-primary-outline" style="float:right">Edit User</button>
      </form>
  </div>
</div>
</div>
@endsection