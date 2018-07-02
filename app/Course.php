<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    public function student(){
        return $this->belongsToMany(User::class,'enrollments', 'user_id', 'course_id')->withPivot('authorized','id')->withTimestamps();
    }
}
