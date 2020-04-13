<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
//use Illuminate\Database\Eloquent\SoftDeletes;


class Course extends Model
{
    
    //use SoftDeletes;
    protected $fillable = [
        'name', 'slug', 'courses_category', 'image', 'course_code'
    ];

    protected $dates = [
        
    ];
}