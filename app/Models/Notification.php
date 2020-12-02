<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model as Model;

class Notification extends Model
{

    protected $table = 'notifications';

    public $timestamps  = false;
    public $fillable = [
		'target_id',
		'type',
		'origin_id',
		'description'
    ];
    public $hidden = ['id'];

   
   
}