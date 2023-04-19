<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id_user',
        'bg_image',
        'titre',
        'adresse',
        'telephone',
        'linkedin_link',
        'github_link',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
