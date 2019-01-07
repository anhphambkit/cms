<?php

namespace Core\Base\Controllers\Admin;

use Illuminate\Routing\Controller;
use Core\Theme\Foundation\Asset\Manager\AssetManager;
use Core\Theme\Foundation\Asset\Pipeline\AssetPipeline;
use Core\Theme\Foundation\Asset\Types\AssetTypeFactory;

abstract class BaseAdminController extends Controller
{
    /**
     * @var AssetManager
     */
    protected $assetManager;
    /**
     * @var AssetPipeline
     */
    protected $assetPipeline;
    /**
     * @var AssetTypeFactory
     */
    protected $assetFactory;

    public function __construct()
    {
		$this->assetManager  = app(AssetManager::class);
		$this->assetPipeline = app(AssetPipeline::class);
		$this->assetFactory  = app(AssetTypeFactory::class);
    }
}
