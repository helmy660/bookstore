@extends('layouts.admin.nav')

@section('content')
<div class="col-sm-12">

<div class="row">
<div class="col-sm-12">
    <h1 style="margin-left:30%;margin-bottom:2%;margin-top:2%">List of all Books</h1>   

    <div>
    <a style="margin: 19px;" href="{{ route('books.create')}}" class="btn btn-dark">New Book</a>
    </div>  
   
  <table class="table table-dark">
    <thead>
        <tr>
          <td>#</td>
          <td>Name</td>
          <td>Image</td>
          <td>author</td>
          <td>Description</td>
          <td>rate</td>
          <td>Copies #</td>
          <td>Price</td>
          <td>category_id</td>
        
          <td colspan = 2>Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
        <tr>
            <td>{{$book->id}}</td>
            <td>{{$book->book_name}}</td>
            <td><img src="{{$book->book_image}}" width="100" height="100" /></td>
            <td>{{$book->author}}</td>
            <td>{{$book->description}}</td>
            <td>{{$book->rate}}</td>
            <td>{{$book->copies_num}}</td>
            <td>{{$book->price}}</td>
            <td>{{$book->category_id}}</td>
            
            
            <td>
                <a href="{{ route('books.edit',$book->id)}}" class="btn btn-info">Edit</a>    
            </td>
            
            <td>
            @can('delete', $book)
                <form action="{{ route('books.destroy', $book->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
              @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div>
</div>
@endsection