<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model as Model;

class Tags extends Model
{

    protected $table = 'tags';

    public $timestamps  = false;
    public $fillable = [
        'event_id','tag'
    ];

   
   
}
