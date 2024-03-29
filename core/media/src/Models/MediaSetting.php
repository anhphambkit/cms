<?php

namespace Core\Media\Models;

use Eloquent;
use Exception;

class MediaSetting extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'media_settings';

    /**
     * @var array
     */
    protected $fillable = ['key', 'value', 'user_id'];

    /**
     * @param $value
     * @return array
     */
    public function getValueAttribute($value)
    {
        try {
            return json_decode($value, true) ?: [];
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param $value
     * @author Trinh Le
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = json_encode($value);
    }
}