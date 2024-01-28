<?php

namespace Rupadana\FilamentAnnounce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'custom_color',
        'title',
        'body',
        'icon',
        'users',
    ];

    protected $casts = [
        'users' => 'array',
    ];
}
