<?php

namespace Plugins\Product\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Product\Repositories\Interfaces\LookBookRepositories;
use Plugins\Product\Repositories\Interfaces\ProductAttributeValueRelationRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Plugins\Product\Repositories\Interfaces\ManufacturerRepositories;
use Plugins\Product\Repositories\Interfaces\BusinessTypeRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCollectionRepositories;
use Plugins\Product\Repositories\Interfaces\ProductColorRepositories;
use Plugins\Product\Repositories\Interfaces\ProductMaterialRepositories;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Plugins\Product\Repositories\Interfaces\ProductSpaceRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCouponRepositories;
use Plugins\Product\Repositories\Interfaces\SaveForLaterRepositories;
use Plugins\Product\Repositories\Interfaces\WishListRepositories;
use Plugins\Product\Services\BusinessTypeServices;
use Plugins\Product\Services\Implement\ImplementBusinessTypeServices;
use Plugins\Product\Services\Implement\ImplementLookBookServices;
use Plugins\Product\Services\Implement\ImplementProductAttributeValueServices;
use Plugins\Product\Services\Implement\ImplementProductCategoryServices;
use Plugins\Product\Services\Implement\ImplementProductServices;
use Plugins\Product\Services\Implement\ImplementProductSpaceServices;
use Plugins\Product\Services\LookBookServices;
use Plugins\Product\Services\ProductAttributeValueServices;
use Plugins\Product\Services\ProductCategoryServices;
use Plugins\Product\Services\ProductServices;
use Plugins\Product\Services\ProductSpaceServices;


class ProductServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Prefix support binding eloquent
     * @author TrinhLe
     */
    const PREFIX_REPOSITORY_ELOQUENT = 'Eloquent\\Eloquent';

    /**
     * Prefix support binding cache
     * @author TrinhLe
     */
    const PREFIX_REPOSITORY_CACHE = 'Caches\\Cache';

    /**
     * @author AnhPham
     */
    public function register()
    {
        register_repositories($this);
        $this->app->singleton(ProductServices::class, ImplementProductServices::class);
        $this->app->singleton(BusinessTypeServices::class, ImplementBusinessTypeServices::class);
        $this->app->singleton(ProductCategoryServices::class, ImplementProductCategoryServices::class);
        $this->app->singleton(LookBookServices::class, ImplementLookBookServices::class);
        $this->app->singleton(ProductSpaceServices::class, ImplementProductSpaceServices::class);
        $this->app->singleton(ProductAttributeValueServices::class, ImplementProductAttributeValueServices::class);

        $this->app['router']->aliasMiddleware('checkout', \Plugins\Product\Middlewares\CheckoutMiddleware::class);
    }

    /**
     * @return array
     */
    public function getRespositories():array
    {
        return [
            ProductRepositories::class           => \Plugins\Product\Models\Product::class,
            ManufacturerRepositories::class      => \Plugins\Product\Models\ProductManufacturer::class,
            ProductColorRepositories::class      => \Plugins\Product\Models\ProductColor::class,
            ProductCollectionRepositories::class => \Plugins\Product\Models\ProductCollection::class,
            ProductMaterialRepositories::class   => \Plugins\Product\Models\ProductMaterial::class,
            BusinessTypeRepositories::class      => \Plugins\Product\Models\ProductBusinessType::class,
            ProductCategoryRepositories::class   => \Plugins\Product\Models\ProductCategory::class,
            LookBookRepositories::class          => \Plugins\Product\Models\LookBook::class,
            ProductSpaceRepositories::class      => \Plugins\Product\Models\ProductSpace::class,
            ProductCouponRepositories::class     => \Plugins\Product\Models\ProductCoupon::class,
            ProductAttributeValueRelationRepositories::class     => \Plugins\Product\Models\ProductAttributeValueRelation::class,
            WishListRepositories::class     => \Plugins\Product\Models\WishList::class,
            SaveForLaterRepositories::class     => \Plugins\Product\Models\SaveForLater::class,
        ];
    }

    /**
     * @author AnhPham
     */
    public function boot(){}
}
