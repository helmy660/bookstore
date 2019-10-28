<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBook extends Model
{
    //
    protected $fillable = ['number_of_days', 'leased','favourite','user_id', 'book_id'];

}
