@extends('layouts.Book.bookDetails')

@section('addComment')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    
                            <h2 >Add your Review </h2>
                 <div>
                    <form method="POST" action="{{ route('layouts.comments.store') }}" }}">
                        @csrf
                     <div class="row">
                       <div class = "col-sm-9">
                       <div class="form-group">
                  <textarea class="form-control" placeholder="Add Your Review Here" name="comment_body" rows="5" id="comment"></textarea>
                       </div> 
                       </div>
                       <div class = "col-sm-3">
                        <img src={{ asset('images/EmptyStar.png') }} >
                        <img src={{ asset('images/EmptyStar.png') }} >
                        <img src={{ asset('images/EmptyStar.png') }} >
                        <img src={{ asset('images/EmptyStar.png') }} >
                        <img src={{ asset('images/EmptyStar.png') }} >
                       </div>
                     </div>
                     <div class="row">
                       <div class = "col-sm-12">
                       <button type="submit" class="btn btn-danger">Add Review</button>
                       </div>
                     </div>  
                    </form>
                 
                </div>
            </div>
        </div>
    </div>

@endsection

