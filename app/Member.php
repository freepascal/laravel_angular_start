<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $fillable = [
        'name',
        'address',
        'age',
        'photo'
    ];
}
?>
