<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'key',
    ];

    // Générer uuid et key avant création
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($apiKey) {
            $apiKey->uuid = (string) Str::uuid();
            $apiKey->key = Str::random(32); 
        });
    }

    // Relation vers User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
