<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model as Model;

use function PHPSTORM_META\map;

class Option extends Model
{

    protected $primaryKey = null;

    public $incrementing = false;

    protected $table = 'options';

    public $timestamps  = false;
    public $fillable = [
       'poll_id','content'
    ];
   
    public function votes()
    {
        return Vote::where('poll_id',$this->poll_id)->where('content',$this->content)->count();
    }

    public function checkVoted($id,$poll_id){
       $aux = Vote::where('poll_id',$poll_id)->where('content',$this->content)->where('voter_id',$id)->first();

       if( $aux != null)
       return true;
       
       return false;
    }
   
   
   
}
