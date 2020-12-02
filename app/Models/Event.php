<?php


namespace App\Models;

use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model as Model;

class Event extends Model
{
    use SearchableTrait;

    public function searchableAs()
    {
        return '_event_name_';
    }


    protected $table = 'events';

    public $timestamps  = false;
    public $fillable = [
        'event_name','owner_id','description','price','start_date','end_date','private_event','location','paypal'
    ];

    public $hidden = [
     'removed'
    ];


    public function comments()
    {
        return $this->hasMany('App\Models\Comment','event_id','id');

    }

    public static function get_owner(){
        $owner_id = 'owner_id';
        return $owner_id;
    }

    public function attending()
    {
        return $this->hasMany('App\Models\Attending','event_id','id');
    }
   
    public function images()
    {
        return $this->hasMany('App\Models\Event_Image','event_id','id');
    }
   

    public function tags()
    {
        return $this->hasMany('App\Models\Tags','event_id','id');
     
    }

    public function polls()
    {
        return $this->hasMany('App\Models\Poll','event_id','id');
     
    }

    protected $searchable = [
        'columns' => [
            'event_name' => 10,
            'description' => 10,
            'location' => 8,
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
            
        return array('event_name' => $array['event_name'],
        'description' => $array['description'],
        'price' => $array['price'],
        'start_date' => $array['start_date'],
        'location' => $array['location'],
    );
    }
}
