<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
// コンソールで「php arisan make:model Student -m」を実行
{
    protected $table = 'students';

    protected $fillable = ['name', 'course'];
}
