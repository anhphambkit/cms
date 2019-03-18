<?php

namespace Core\Media\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Core\Media\ValueObjects\MediaPath;

class CreateThumbnails implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var MediaPath
     */
    private $path;

    public function __construct(MediaPath $path)
    {
        $this->path = $path;
    }

    /**
     * Creage thumbnail image
     * @author  unknown
     * @return mixed
     */
    public function handle()
    {
        $imagy = app('imagy');
        return $imagy->createAll($this->path);
    }
}
