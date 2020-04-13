<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class Topic extends Model
{
    
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'topic_name', 'topic_code', 'topic_slug', 'start_time', 'description', 'status', 'image', 'link', 'course_code', 'end_date', 'video_link', 'note'
    ];

    protected $dates = [
        'deleted_at', 
    ];
}