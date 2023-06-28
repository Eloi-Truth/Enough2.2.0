<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Community extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'about',
        'user_id'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'community_user');
    }
    
}
