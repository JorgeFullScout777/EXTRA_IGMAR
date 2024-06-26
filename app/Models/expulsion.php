<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expulsion extends Model
{
    use HasFactory;

    protected $table = 'expulsions';

    protected $fillable = [
        'user_id',
        'community_id',
    ];
}
