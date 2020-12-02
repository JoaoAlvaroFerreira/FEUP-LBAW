<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model as Model;

class Invited extends Model
{

    protected $table = 'invited';

    
    public $incrementing = false;
    public $timestamps  = false;

    public $fillable = [
		'event_id',
		'inviter_id',
		'invited_id',
    ];
    

   
   
}