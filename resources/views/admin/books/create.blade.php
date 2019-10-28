@extends('layouts.admin.nav')

@section('content')
<div class="row">
 <div class="col-sm-8 offset-sm-2">

    <h1 class="display-5">Add a Book</h1>
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
      <form method="post" action="{{ route('books.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">    
              <label for="book_name">Book Name:</label>
              <input type="text" class="form-control" name="book_name" value="{{ old('book_name') }}"/>
          </div>

          <div class="form-group">
              <label for="author">Author:</label>
              <input type="text" class="form-control" name="author" value="{{ old('author','') }}"/>
          </div>

          <div class="form-group">
              <label for="category">Category:</label>
              <select name="category" value="{{ old('category','') }}" >
              @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
              @endforeach
              </select>
          </div>

          <div class="form-group">
              <label for="copies_num">Number of Copies:</label>
              <input type="number" class="form-control" name="copies_num" min="1" value="{{ old('copies_num','') }}"/>
          </div>

          <div class="form-group">
              <label for="price">Price:</label>
              <input type="number" class="form-control" name="price" min="1" value="{{ old('price','') }}"/>
          </div>

          <div class="form-group">
              <label for="description">Description:</label>
              <textarea class="form-control" name="description" rows="5" value="{{ old('description','') }}" ></textarea>
          </div>

          <div class="form-group">
              <label for="book_image">Book Image:</label><br />
              <input type="file"  name="book_image" />
          </div>
                      
          <button type="submit" class="btn btn-primary-outline" style="float:right">Add Book</button>
      </form>
  </div>
</div>
</div>
@endsection