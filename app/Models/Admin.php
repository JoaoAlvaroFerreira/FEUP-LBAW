<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model as Model;

class Admin extends Model
{

    protected $table = 'admins';

    public $timestamps  = false;

    public $hidden = [
     'id','admin_date'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
   
}
