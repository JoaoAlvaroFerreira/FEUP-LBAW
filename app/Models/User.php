<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable
{
    use SearchableTrait;
    use Notifiable;

    public $timestamps  = false;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'join_date', 'bio', 'photo','banned'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'password'
    ];

    public function isAdmin()
    {
        $aux = Admin::where('id',$this->id)->first();
        
        if( $aux != null)
        return true;
        
        else return false;
       
    }

    public static function getId()
    {
        $id = 'id';
        return $id;
    }

    public function isInvited($event_id){
       $aux = Invited::where('event_id',$event_id)->where('invited_id',$this->id)->first();
       if($aux != null)
       return true;

       return false;
    }

    public function isAttending($event_id){
        $aux = Attending::where('event_id',$event_id)->where('attendee_id',$this->id)->first();
        if($aux != null)
        return true;
 
        return false;
    }

    public function getImageAttribute()
    {
        return $this->photo;
    }

    /**
     * The columns of the full text index
     */
    protected $searchable = [
        'columns' => [
            'email' => 10,
            'name' => 10,
            'bio' => 10,
        ],

    ];

            /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
            
        return array('name' => $array['name'],
        'email' => $array['email'],
    );
    }


}
