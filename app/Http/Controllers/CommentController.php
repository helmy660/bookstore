<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $comments = auth()->user()->comments ; 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // $input = $request->all();
        // $input['user_id'] = auth()->user()->id;
        // $request->validate([
        //     'body'=>['required']
        // ]) ; 
        // $input->save();
        // Comment::create($input);

        $user_id = auth()->user()->id  ; 
        $request->validate([
                'body'=>['required']
            ]) ;
        $comm_before = Comment::where('user_id','=',$user_id )->where('book_id','=',$request->get('book_id'))->get() ;
        
        if (sizeof($comm_before)>0)
        $last_rate = $comm_before[0]->rate ; 
        else 
        $last_rate = 0 ; 

        $comment = new Comment([
            'body' => $request->get('body') , 
             'book_id' => $request->get('book_id') ,
             'user_id' => $user_id , 
             'rate' =>  $last_rate 
        ]) ; 
            $comment->save() ; 
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
