<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model as Model;

class Report extends Model
{

    protected $table = 'report';

    public $timestamps  = false;
    public $fillable = [
        'report_note','comment_id'
    ];

    public $hidden = ['id'];

   
   
}
