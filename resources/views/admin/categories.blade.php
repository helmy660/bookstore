@extends('layouts.admin.nav')

@section('content')
<div class="col-sm-12">

<div class="row">
<div class="col-sm-12">
    <h1 style="margin-left:30%;margin-bottom:2%;margin-top:2%">List of all categories</h1>   

    <div>
    <a style="margin: 19px;" href="{{ route('categories.create')}}" class="btn btn-dark">New category</a>
    </div>  
   
  <table class="table table-dark">
    <thead>
        <tr>
          <td>#</td>
          <td>Name</td>
          <td>Description</td>
        
          <td colspan = 2>Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{$category->id}}</td>
            <td>{{$category->name}}</td>
            <td>{{$category->description}}</td>            
            
            <td>
                <a href="{{ route('categories.edit',$category->id)}}" class="btn btn-info">Edit</a>    
            </td>
            
            <td>
                <form action="{{ route('categories.destroy', $category->id)}}" method="post">
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