<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    /**
     * Fillable fields for a course
     *
     * @return array
     */
    protected $fillable = ['comment','votes','spam','reply_id','page_id','users_id'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    // protected $dateFormat = "U";

    public function replies()
    {
        return $this->hasMany('App\Comment','id','reply_id');
    }
}