<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model as Model;

class Comment extends Model
{

    protected $table = 'comments';

    public $timestamps  = false;
    public $fillable = [
    'commenter_id',
    'event_id' ,
    'content',
    'photo',
    'removed'
    ];

    public $hidden = [
     'id'
    ];

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }
   
}
