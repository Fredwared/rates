<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rates extends Model
{
    protected $fillable = ['from', 'to', 'value'];
}
