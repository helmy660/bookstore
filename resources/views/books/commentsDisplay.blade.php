@foreach ($comments as $comment) 
@if ($comment->body != "Rate without comment ")  
<div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid"/>
                   
                </div>
                <div class="col-md-10">
                    <p>
                        <span class="float-left" ><strong>{{ $comment->user->name }}</strong>
                        {{--  <h1>{{$comment->rate}}</h1>  --}}
                            <div class="user_rate">
                                <span id="user{{$comment->id}}_rate_1" class="ratingStar emptyRatingStar" > &nbsp;</span>
                                <span id="user{{$comment->id}}_rate_2" class="ratingStar emptyRatingStar" >&nbsp;</span>
                                <span id="user{{$comment->id}}_rate_3" class="ratingStar emptyRatingStar" >&nbsp;</span>
                                <span id="user{{$comment->id}}_rate_4" class="ratingStar emptyRatingStar" >&nbsp;</span>
                                <span id="user{{$comment->id}}_rate_5" class="ratingStar emptyRatingStar" >&nbsp;</span>
                                </div>
                        
                        </span>
                        
                       
                   </p>
                   <div class="clearfix"></div>
                    <p>{{$comment->body}}</p>
                 
                </div>
            </div>
            </div>
            </div>
            <br />
            <br />
            <script>
                
                     
                    console.log("User Rate : ",{{$comment->rate}}) ; 
                
                    for (let i=1 ; i<=5 ; i++){
                       
                        if (i <= {{$comment->rate}}){
                            
                            $(`#user{{$comment->id}}_rate_${i}`).removeClass('emptyRatingStar').addClass('filledRatingStar')
                        }
                    }
                
            </script>
@endif            
@endforeach
<br /> <br /> <br /> 
