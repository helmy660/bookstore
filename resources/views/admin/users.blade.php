@extends('layouts.admin.nav')

@section('content')
<div class="col-sm-12">

<div class="row">
<div class="col-sm-12">
    <h1 style="margin-left:30%;margin-bottom:2%;margin-top:2%">List of all Users</h1>   

    <div>
    <a style="margin: 19px;" href="{{ route('users.create')}}" class="btn btn-dark">New User</a>
    </div>  
   
  <table class="table table-dark">
    <thead>
        <tr>
          <td>#</td>
          <td>Name</td>
          <td>Email</td>
          <td>Username</td>
          <td>Password</td>
          <td>NationalID</td>
          <td>Phone</td>
          <td>Active State</td>
        
          <td colspan = 2>Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->username}}</td>
            <td>{{$user->password}}</td>
            <td>{{$user->nationalid}}</td>
            <td>{{$user->phone}}</td>
            <td>{{$user->isactive}}</td>
            
            
            <td>
                <a href="{{ route('users.edit',$user->id)}}" class="btn btn-info">Edit</a>    
            </td>
            
            <td>
                <form action="{{ route('users.destroy', $user->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>
@endsection