<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoPost extends Model
{
     /**
     * MASS ASSIGN
     */
    protected $fillable = [
        'post_id',
        'post_status',
        'comment_status',
    ];
    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

     /**
     * DB RELATIONS
     */
    //infoposts - posts
    public function post() {
        return $this->belongsTo('App\Post');
    }
}
