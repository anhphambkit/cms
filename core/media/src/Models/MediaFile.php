<?php

namespace Core\Media\Models;

use Core\Media\Services\UploadsManager;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Core\Media\ValueObjects\MediaPath;

class MediaFile extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'media_files';

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var type
     */
    protected $fillable = [
        'name'         ,
        'url'          ,
        'size'         ,
        'mime_type'    ,
        'folder_id'    ,
        'user_id'      ,
        'options'      ,
        'is_public'    ,
        'storage'      ,
        'real_filename',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author TrinhLe
     */
    public function folder()
    {
        /**
         * @var Model $this
         */
        return $this->belongsTo(MediaFolder::class, 'id', 'folder_id');
    }

    /**
     * @return int
     * @author TrinhLe
     */
    public function isShared()
    {
        return MediaShare::where('share_id', '=', $this->id)->where('share_type', '=', 'file')->count();
    }

    // /**
    //  * Description
    //  * @param type $value 
    //  * @return type
    //  */
    // public function getUrlAttribute($value)
    // {
    //     return new MediaPath($value, $this->storage);
    // }

    /**
     * @return string
     * @author TrinhLe
     */
    public function getTypeAttribute()
    {
        $type = 'document';
        if ($this->attributes['mime_type'] == 'youtube') {
            return 'video';
        }

        foreach (config('core-media.media.mime_types') as $key => $value) {
            if (in_array($this->attributes['mime_type'], $value)) {
                $type = $key;
                break;
            }
        }

        return $type;
    }

    /**
     * @return string
     * @author TrinhLe
     */
    public function getHumanSizeAttribute()
    {
        return human_file_size($this->attributes['size']);
    }

    /**
     * @return string
     * @author TrinhLe
     */
    public function getIconAttribute()
    {
        /**
         * @var Model $this
         */
        switch ($this->type) {
            case 'image':
                $icon = 'fa fa-file-image-o';
                break;
            case 'video':
                $icon = 'fa fa-file-video-o';
                break;
            case 'pdf':
                $icon = 'fa fa-file-pdf-o';
                break;
            case 'excel':
                $icon = 'fa fa-file-excel-o';
                break;
            case 'youtube':
                $icon = 'fa fa-youtube';
                break;
            default:
                $icon = 'fa fa-file-text-o';
                break;
        }
        return $icon;
    }

    /**
     * @param $value
     * @return mixed
     * @author TrinhLe
     */
    public function getOptionsAttribute($value)
    {
        return json_decode($value, true) ?: [];
    }

    /**
     * @author TrinhLe
     * @param $value
     */
    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    /**
     * @var array
     * @author TrinhLe
     */
    public static $mimeTypes = [
        'zip' => 'application/zip',
        'mp3' => 'audio/mpeg',
        'bmp' => 'image/bmp',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'csv' => 'text/csv',
        'txt' => 'text/plain',
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    ];

    /**
     * @author TrinhLe
     */
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($file) {
            /**
             * @var MediaFile $file
             */
            if ($file->isForceDeleting()) {
                MediaShare::where('share_id', '=', $file->id)->where('share_type', '=', 'file')->forceDelete();

                $uploadManager = new UploadsManager();
                $path = str_replace(config('core-media.media.upload.folder'), '', $file->url);
                $uploadManager->deleteFile($path);
            } else {
                MediaShare::where('share_id', '=', $file->id)->where('share_type', '=', 'file')->delete();
            }

            static::restoring(function ($file) {
                MediaShare::where('share_id', '=', $file->id)->where('share_type', '=', 'file')->restore();
            });
        });
    }

    /**
     * @param $value
     * @return array
     */
    public function getFocusAttribute($value)
    {
        try {
            return json_decode($value, true) ?: [];
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param $value
     * @author TrinhLe
     */
    public function setFocusAttribute($value)
    {
        $this->attributes['focus'] = json_encode($value);
    }

    /**
     * @author TrinhLe
     */
    public function __wakeup()
    {
        parent::boot();
    }
}
