<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model as Model;

class Attending extends Model
{

    protected $primaryKey = null;

    public $incrementing = false;
    protected $table = 'attending';

    public $timestamps  = false;
    public $fillable = [
    'attendee_id',
    'event_id' ,
    ];

  
    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }
   
    public function attendee()
    {
        return $this->hasOne('App\Models\User');
    }
}
