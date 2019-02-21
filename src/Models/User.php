<?php

namespace TCG\Voyager\Models;

use Carbon\Carbon;
use MongoDB\BSON\UTCDateTime;
use TCG\Voyager\Contracts\User as UserContract;
use TCG\Voyager\Traits\VoyagerUser;

class User extends UserBase implements UserContract
{
    use VoyagerUser;

    protected $guarded = [];

    protected $casts = [
        'settings' => 'array',
    ];

    public function getAvatarAttribute($value)
    {
        if (is_null($value)) {
            return config('voyager.user.default_avatar', 'users/default.png');
        }

        return $value;
    }

    public function setCreatedAtAttribute($value)
    {
        if($value instanceof UTCDateTime){
            $value = $value->toDateTime();
            $value = $value->format('Y-m-d H:i:s');
        }
        $this->attributes['created_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function setLocaleAttribute($value)
    {
        $this->attributes['settings'] = collect($this->settings)->merge(['locale' => $value]);
    }
    public function fromJson($value, $asObject = false)
    {
        if(is_string($value)){
            return json_decode($value, ! $asObject);
        }
        return $value;
    }

    public function setSettingsAttribute($value){
        if(isset($this->settings)){
            return $this->settings;
        }
        return;
    }
    public function getLocaleAttribute()
    {
        if(isset($this->settings['locale'])){
            return $this->settings['locale'];
        }
        return;
    }
}
