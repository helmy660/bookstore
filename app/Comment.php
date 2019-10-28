<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //
    // use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['rate','body', 'user_id', 'book_id'];

    // public function book()
    // {
    //   return $this->belongsTo('App\Book');
    // }
   
    public function user()
    {
      return $this->belongsTo('App\User');
    }
}
