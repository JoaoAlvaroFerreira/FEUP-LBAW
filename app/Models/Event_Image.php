<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model as Model;

class Event_Image extends Model
{

    protected $table = 'event_image';

    
    public $incrementing = false;

    public $timestamps  = false;
    public $fillable = [
        'event_id','image_url'
    ];

   
   
}