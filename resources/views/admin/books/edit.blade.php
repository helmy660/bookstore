@extends('layouts.admin.nav')

@section('content')
<div class="row">
 <div class="col-sm-8 offset-sm-2">

    <h1 class="display-6">Edit Book " {{$book->book_name}} "</h1>
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
      <form method="post" action="{{ route('books.update',$book->id)}}" enctype="multipart/form-data">
        @method('PATCH') 
          @csrf
          <div class="form-group">    
              <label for="book_name">Book Name:</label>
              <input type="text" class="form-control" name="book_name" value="{{ old('book_name',$book->book_name) }}"/>
          </div>

          <div class="form-group">
              <label for="author">Author:</label>
              <input type="text" class="form-control" name="author" value="{{ old('author',$book->author) }}"/>
          </div>

          <div class="form-group">
              <label for="category">Category:</label>
              <select name="category" value="{{ old('category',$book->catrgory_id) }}" >
              @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
              @endforeach
              </select>
          </div>

          <div class="form-group">
              <label for="copies_num">Number of Copies:</label>
              <input type="number" class="form-control" name="copies_num" min="1" value="{{ old('copies_num',$book->copies_num) }}"/>
          </div>

          <div class="form-group">
              <label for="price">Price:</label>
              <input type="number" class="form-control" name="price" min="1" value="{{ old('price',$book->price) }}"/>
          </div>

          <div class="form-group">
              <label for="description">Description:</label>
              <textarea class="form-control" name="description" rows="5" value="" >{{ old('description',$book->description) }}</textarea>
          </div>

          <div class="form-group">
              <label for="book_image">Book Image:</label><br />
              <input type="file"  name="book_image" />
          </div>
                      
          <button type="submit" class="btn btn-primary-outline" style="float:right">Edit Book</button>
      </form>
  </div>
</div>
</div>
@endsection