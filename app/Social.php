<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $fillable = [
        'social_name'
     ];
 
     protected $primaryKey = 'social_id';
 
     public $timestamps = false;
}
