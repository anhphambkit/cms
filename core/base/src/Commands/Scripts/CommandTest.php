<?php

namespace Core\Base\Commands\Scripts;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Core\Media\Models\MediaFile;

class CommandTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate command';

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Create a new command instance.
     *
     * @param Composer $composer
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // MediaFile::withTrashed()->restore();
        $file = MediaFile::find(40);

        $url = \BFileService::renderUrl($file->url, $file->storage);

        print_r($url);
        print_r("\n");
        // \BFileService::deleteMedia($file, "media_path");
    }
}