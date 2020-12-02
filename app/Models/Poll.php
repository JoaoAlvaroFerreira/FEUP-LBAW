<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model as Model;

class Poll extends Model
{

    protected $table = 'poll';

    public $timestamps  = false;
    public $fillable = [
        'question', 'event_id', 'target_id'
    ];
    public $hidden = ['id'];

    public function options()
    {
        return $this->hasMany('App\Models\Option', 'poll_id', 'id');
    }

    public function ifVote($user_id)
    {
       
        $options = Option::where('poll_id', $this->id)->get();
        foreach ($options as $option) {
            if ($option->checkVoted($user_id,$this->id))
                return true;
        }
        return false;
    }
}
