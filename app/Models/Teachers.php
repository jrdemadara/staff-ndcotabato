<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teachers extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'teacher';
    protected $fillable = [
        'teaserial',
        'idno',
        'lastname',
        'firstname',
        'middlename',
    ];

}
