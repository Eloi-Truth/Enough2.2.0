<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public function communities(){
    //     return $this->hasMany(Community::class,,'community_user');
    // }

    public function posts(){
        return $this->hasMany(Post::class,'user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function communitiesuser()
    {
        return $this->hasMany(CommunityUser::class);
    }


    public function communities(): BelongsToMany
    {
        return $this->belongsToMany(Community::class, 'community_user','user_id');
    }
    

}
