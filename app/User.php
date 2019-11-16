<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Overtrue\LaravelFollow\Traits\CanFollow;
use Overtrue\LaravelFollow\Traits\CanBeFollowed;
use Overtrue\LaravelFollow\Traits\CanLike;
use Overtrue\LaravelFollow\Traits\CanBeLiked;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes , CanFollow , CanBeFollowed , CanLike , CanBeLiked;

    protected $dates = ['deleted_at'];



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    

    protected $fillable = [
        'name', 'email', 'password', 'active', 'activation_token', 'profile_img', 'cover_img' ,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','activation_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
 */
// public function followers()
// {
//     return $this->belongsToMany(User::class, 'followers', 'leader_id', 'follower_id')->withTimestamps();
// }

/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
 */
// public function followings()
// {
//     return $this->belongsToMany(User::class, 'followers', 'follower_id', 'leader_id')->withTimestamps();
// }

}
