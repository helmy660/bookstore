@extends('layouts.user.userHome')
@extends('layouts.app2')

@section('catSideBar')
        <ul class="list-group">
        @foreach($categories as $category)
            @if($filterMode=='allBooks')
                <li class="list-group-item"><a href="{{ url('booksByCat/'.$category->id.'/3')}}" style="background-color:{{ $category->id==$current_cat ? '#ffff99':'none'}}">{{$category->name}}</a></li>
            @elseif($filterMode=='leasedBooks')
                <li class="list-group-item"><a href="{{ url('leased/bycat/'.$category->id.'/3')}}" style="background-color:{{ $category->id==$current_cat ? '#ffff99':'none'}}">{{$category->name}}</a></li>
            @elseif($filterMode=='favBooks')
                <li class="list-group-item"><a href="{{ url('favourite/bycat/'.$category->id.'/3')}}" style="background-color:{{ $category->id==$current_cat ? '#ffff99':'none'}}">{{$category->name}}</a></li>
            @endif
        @endforeach
        </ul>
@endsection

@section('searchBar')
        <script>
            document.getElementById('{{$filterMode}}').style.backgroundColor='#ffff99';
        </script>

    <div class='col-2 offset-2'>
         <input class="form-control form-control" type="text" placeholder="Search" aria-label="Search">
    </div>
    <div class='col-3'>
        <div>
            <span>Order By </span>
            <div class="btn-group" role="group" aria-label="First group">
            @if($current_cat != 0)
                 @if($filterMode=='allBooks')
                    <a href="{{ url('booksByCat/'.$current_cat.'/1')}}"><button type="button" class="btn btn-outline-info" id='rateBtn'>Rate</button></a>
                    <a href="{{ url('booksByCat/'.$current_cat.'/2')}}"><button type="button" class="btn btn-outline-info" id='latestBtn'>Latest</button></a>
                @elseif($filterMode=='leasedBooks')
                    <a href="{{ url('leased/bycat/'.$current_cat.'/1')}}"><button type="button" class="btn btn-outline-info" id='rateBtn'>Rate</button></a>
                    <a href="{{ url('leased/bycat/'.$current_cat.'/2')}}"><button type="button" class="btn btn-outline-info" id='latestBtn'>Latest</button></a>
                @elseif($filterMode=='favBooks')
                    <a href="{{ url('favourite/bycat/'.$current_cat.'/1')}}"><button type="button" class="btn btn-outline-info" id='rateBtn'>Rate</button></a>
                    <a href="{{ url('favourite/bycat/'.$current_cat.'/2')}}"><button type="button" class="btn btn-outline-info" id='latestBtn'>Latest</button></a>
                @endif
                    
            @else
                @if($filterMode=='allBooks')
                    <a href="{{ url('user/1')}}"><button type="button" class="btn btn-outline-info" id='rateBtn'>Rate</button></a>
                    <a href="{{ url('user/2')}}"><button type="button" class="btn btn-outline-info" id='latestBtn'>Latest</button></a>
                @elseif($filterMode=='leasedBooks')
                    <a href="{{ url('leased/1')}}"><button type="button" class="btn btn-outline-info" id='rateBtn'>Rate</button></a>
                    <a href="{{ url('leased/2')}}"><button type="button" class="btn btn-outline-info" id='latestBtn'>Latest</button></a>
                @elseif($filterMode=='favBooks')
                    <a href="{{ url('favourite/1')}}"><button type="button" class="btn btn-outline-info" id='rateBtn'>Rate</button></a>
                    <a href="{{ url('favourite/2')}}"><button type="button" class="btn btn-outline-info" id='latestBtn'>Latest</button></a>
                @endif
            @endif


            @if($order_by==1)
                <script>
                    document.getElementById('rateBtn').classList.add("active");
                 </script>
            @elseif($order_by==2)
                <script>
                    document.getElementById('latestBtn').classList.add("active");
                </script>
            @endif

            </div>
        </div>
    </div>
@endsection

@section('booksDiv')
                <div class='row'>
                @foreach($books as $book)
                    <div class='col-3 book' value=[{{$book->id}},{{$book->category_id}}]>
                            <div class='row'>
                                <div class='thumbnail col-12'>
                                    <img src={{$book->book_image}} alt="" class="img-thumbnail">
                                </div>
                            </div>

                            <div class='row'>

                                    <div class=col-6>
                                        <span><b>Avg Rate</b></span>
                                    </div>
                                    <div class='col-6'>
                                        <div class="avg_rate">
                                            
                                            @for ($i = 1; $i <= $book->rate; $i++)
                                                    <img src="{{ asset('images/FilledStar.png') }}" />
                                            @endfor

                                            @for ($i = 1; $i <= 5-$book->rate; $i++)
                                                    <img src="{{ asset('images/EmptyStar.png') }}" />
                                            @endfor

                                        </div>
                                    </div>
                            </div>

                            <div class='row'>
                                <div class='col-12'>
                                    
                                    <h3><a href="{{url('/books/'.$book->id)}}">{{$book->book_name}}</a></h3>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-12'>
                                    <h5><span>By: </span>{{$book->author}}</h5>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-12'>
                                    <p style="word-wrap:break-word">{{$book->description}}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class='col-8'>
                                <p><span id="copies" value={{$book->copies_num}} >{{$book->copies_num}} </span> Copies available</p>
                                </div>
                                <div class='col-1 offset-1'>
                                    <!-- <span style="font-size:200%;color:red;">&hearts;</span> -->
                                    <img class="favIcon" id="{{$book->id}}" data-bookID="{{$book->id}}" data-favState="{{$book->favourite}}" src={{ $book->favourite == 0 ? asset('images/EmptyHeart.png') : asset('images/FilledHeart.png') }}  width="20" height="20" >
                                </div>
                            </div>

                            <br>

                            <div class='row'>
                                <div class='col-12 text-center'>
                                    <button class='btn btn-primary btn-block' id= "show_lease-div" {{($book->copies_num <= 0) || ($book->leased === 1) ?  'disabled':null}}>Lease</button>
                                </div>
                                <div class="lease-options animated card container">
                                    <h1>Lease Options</h1>
                                        <div class="form-group">
                                            <label>Number Of Days </label>
                                            <input class="form-control" min='1' value="1" max='100' type="number" id="number_of_days" />
                                            <br /> 
                                            <button class="btn btn-danger" type="submit" id="lease_btn" data-bookID="{{$book->id}}"> Lease </button>
                                        </div>
                                </div>
                            </div>
                    </div>
                @endforeach
                </div>
                <br><br>
                <div class='container'>
                    <div style='margin-left: 280px;'>
                        {{ $books->links() }}                    
                    </div>
                </div>
@endsection



@section('javascript')
<meta name="csrf-token" content="{{ csrf_token() }}" />
        <script>
            $(document).ready(function(){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                console.log('works') ;
    // ================================ Click Add Book to Fav Btn ===========================//
                $(".favIcon").click(function(e){
                    //alert("Clikced") ; 
                    if (this.getAttribute("src") == "{{asset('images/EmptyHeart.png')}}" )
                        {
                            this.setAttribute("src","{{asset('images/FilledHeart.png')}}") ;

                        }
                     
                    else 
                    this.setAttribute("src","{{asset('images/EmptyHeart.png')}}") ;
                    let favChangeTo;
                    if (this.getAttribute("data-favState")==0)
                        favChangeTo=1;
                    else 
                        favChangeTo=0;

                        $.ajax({
                        url: "{{url('addToFav')}}",
                        type:"POST" ,
                         
                        data: {'_token':'{{csrf_token()}}' ,
                        'book_id' : this.getAttribute("data-bookID")  ,
                        'favourite': favChangeTo } , 
                        success:function(data){
                            //alert(data);
                            
                        },error:function(){ 
                            alert("error!!!!");
                        }
                    });
            })


    //================================= Show Lease Options ================================// 

                $('#show_lease-div').click(function(){
                $('.lease-options').css("display","block").addClass('bounceInDown') ; 
            })

    // ================================ Click Lease Book Btn ===========================//

            $("#lease_btn").click(function(){
                $.ajax({
                    url: "{{url('leaseBook')}}",
                    type:"POST" ,
                     
                    data: {'_token':'{{csrf_token()}}' , 
                            'book_id' : this.getAttribute("data-bookID"),
                            'number_of_days':$('#number_of_days').val() } , 
                    success:function(data){
                        
                    },error:function(){ 
                        alert("error!!!!");
                    }
                });

                $("#copies").html(parseInt($("#copies").html() ) -1 )
                 //end of ajax
                 $(this).attr('disabled','true') ; 
                 $('#show_lease-div').attr('disabled','true') ; 
                 $('.lease-options').css("display","block").removeClass('bounceInDown').addClass('bounceOutUp') ; 

            })
        })
        </script>

@endsection



