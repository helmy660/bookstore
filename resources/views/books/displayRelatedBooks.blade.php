
                <div  class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                          <div class="carousel-item active" style="width: 18rem;">
                                @foreach ($books as $book) 
                                <div class="card">
                                        <img class="card-img-top" src=" {{$book->book_image}}" alt="Card image cap">
                                        <div class="card-body">
                                          <h5 class="card-title">  {{$book->book_name}}</h5>
                                          <p class="card-text">{{$book->description}}</p>
                                          <a  href="{{ url('/books') }}" class="btn btn-primary">Book Pag </a>
                                        </div>
                                      </div>
                                      @endforeach
                          </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                      </div>
