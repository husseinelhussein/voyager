<?php

namespace TCG\Voyager\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $guarded = [];

    public $timestamps = false;
}
