<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',
        'address',
        'province',
        'city',
        'id_user',
        'created_at',
        'updated_at'
    ];
}
