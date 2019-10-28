<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserBook ; 
use App\Book ; 
use App\Comment ; 
class UserBookController extends Controller
{
    //
    public function addToFav (Request $request){
            // console.log("boom") ; 
        
        // if( $request->ajax() ) {
        //     return response()->json([
        //         'testdata' => 'it works!'
        //     ]);
        // }

        $user_id = auth()->user()->id  ; 
        $request->validate([
            'book_id'=>['required']
        ]) ;
        $rel_id = UserBook::where('user_id','=',$user_id )->where('book_id','=',$request->get('book_id'))->get('id') ;
        // return response()->json([
        //     'testdata' => empty($rel_id) , 
        //     'rel' => $rel_id , 
        //     'size' => sizeof($rel_id)
        // ]);
        if(sizeof($rel_id)> 0 ){
            $user_book = UserBook::find($rel_id[0]->id) ; 
            if ($user_book->favourite == true){
                $user_book->favourite = false;
            }

            else if ($user_book->favourite == false){
                $user_book->favourite = true;
            }
            $user_book->book_id = $request->get('book_id');
            $user_book->save();
        }
        
        else{
        $user_book = new UserBook([
            'favourite' => $request->get('favourite') , 
             'book_id' => $request->get('book_id') ,
             'user_id' => $user_id
        ]) ;
        $user_book->save() ; }
          
        return response()->json([
                    'status' => 'it works!'
                ]);
    } 



    // Leased Button Clicked 
    public function leaseBook (Request $request) {

        $user_id = auth()->user()->id  ; 
        $request->validate([
            'book_id'=>['required']
        ]) ;
        $rel_id = UserBook::where('user_id','=',$user_id )->where('book_id','=',$request->get('book_id'))->get('id') ;

        if(sizeof($rel_id)> 0 ){
            $user_book = UserBook::find($rel_id[0]->id) ;
            $user_book->book_id = $request->get('book_id');
            $user_book->leased = 1;
            $user_book->number_of_days = $request->get('number_of_days') ; 
            $user_book->save();
        }
        else {
            $user_book = new UserBook([
                 'leased' => 1, 
                 'book_id' => $request->get('book_id') ,
                 'user_id' => $user_id , 
                 'number_of_days' => $request->get('number_of_days')  

            ]) ;
            $user_book->save() ; 

        }

        $book = Book::find($request->get('book_id')) ; 
        $book->copies_num = ($book->copies_num - 1) ;

        $book->save() ;  


        return response()->json([
            'status' => 'it works!'
        ]);
    }


    // User Rate Book  
    public function rateBook (Request $request) {


        $user_id = auth()->user()->id  ; 
       
        $request->validate([
            'book_id'=>['required'] ,
            'rate'=>['required'] 
        ]) ;

        $rel_id = Comment::where('user_id','=',$user_id )->where('book_id','=',$request->get('book_id'))->get('id') ;

        if(sizeof($rel_id)> 0 ){
            for ($i =  0; $i< sizeof($rel_id) ; $i++){
            $user_book = Comment::find($rel_id[$i]->id) ;
            $user_book->book_id = $request->get('book_id');
            $user_book->rate = $request->get('rate');
            $user_book->save();
        }
        }
        else {
            $user_book = new Comment([
                 'rate' => $request->get('rate'), 
                 'book_id' => $request->get('book_id') ,
                 'body' =>'Rate without comment ' ,
                 'user_id' => $user_id
            ]) ;
            $user_book->save() ; 

        }


        $book = Book::find($request->get('book_id')) ; 
        $avgRate = ( $request->get('rate') + $book->rate ) / ( $book->number_of_rates + 1 ) ; 
        $book->number_of_rates = ($book->number_of_rates + 1) ;
        $book->rate = $avgRate ;  

        $book->save() ;  


        return response()->json([
            'status' => 'it works!'
        ]);
    }
    
}
