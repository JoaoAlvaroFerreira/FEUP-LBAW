<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model as Model;

class Vote extends Model
{

    protected $primaryKey = null;

    public $incrementing = false;

    protected $table = 'vote';

    public $timestamps  = false;
    public $fillable = [
       'poll_id','voter_id','content'
    ];

   
   
}
