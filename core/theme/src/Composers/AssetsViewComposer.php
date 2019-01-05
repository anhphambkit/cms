<?php

namespace Core\Theme\Composers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Core\Theme\Foundation\Asset\Manager\AssetManager;
use Core\Theme\Foundation\Asset\Pipeline\AssetPipeline;
use Core\Theme\Foundation\Asset\Types\AssetTypeFactory;

class AssetsViewComposer
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
    /**
     * @var Request
     */
    private $request;

    public function __construct(AssetManager $assetManager, AssetPipeline $assetPipeline, AssetTypeFactory $assetTypeFactory, Request $request)
    {
        $this->assetManager = $assetManager;
        $this->assetPipeline = $assetPipeline;
        $this->assetFactory = $assetTypeFactory;
        $this->request = $request;
    }

    /**
     * Register pipeline view admin
     * @param View $view 
     * @author TrinhLe
     * @return type
     */
    public function compose(View $view)
    {
        if(!app()->runningInConsole())
        {
            $assets = $cssRequired = $jsRequired = array();
            if ($this->inAdministration() === false) {
                $assets      = config('resources.frontend-assets');
                $cssRequired = config('resources.frontend-required-assets.css');
                $jsRequired  = config('resources.frontend-required-assets.js');
                
            }else
            {
                $assets      = config('resources.admin-assets');
                $cssRequired = config('resources.admin-required-assets.css');
                $jsRequired  = config('resources.admin-required-assets.js');
            }
            list($cssFiles,$jsFiles) = $this->bindAssets($assets, $cssRequired, $jsRequired);
            $view->with('cssFiles',$cssFiles);
            $view->with('jsFiles', $jsFiles);
        }
    }

    /**
     * Description
     * @param type $assets 
     * @param type $cssRequired 
     * @param type $jsRequired 
     * @author TrinhLe
     */
    protected function bindAssets($assets, $cssRequired, $jsRequired)
    {
        foreach ($assets as $assetName => $path) {
            $path = $this->assetFactory->make($path)->url();
            $this->assetManager->addAsset($assetName, $path);
        }
        $this->assetPipeline->requireCss($cssRequired);
        $this->assetPipeline->requireJs($jsRequired);

        return [$this->assetPipeline->allCss(),$this->assetPipeline->allJs()];
    }

    /**
     * Check if we are in the administration
     * @author TrinhLe
     * @return bool
     */
    protected function inAdministration()
    {
        $segment = 1;
        return app(Request::class)->segment($segment) === config('core-base.cms.router-prefix.admin');
    }
}
