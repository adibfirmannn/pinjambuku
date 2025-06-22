<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Mahasiswa extends Model implements Authenticatable
{
    use HasFactory, AuthenticableTrait, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [
        'id',
    ];
}
