<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUser extends Model
{
    use HasFactory;

    protected $table = 'community_user';

    protected $fillable = [
        'community_id',
        'user_id',
        // outras colunas da tabela
    ];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
}
