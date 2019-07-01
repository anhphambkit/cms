<?php

namespace Plugins\Product\Models;

use Carbon\Carbon;
use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Plugins\CustomAttributes\Models\AttributeValueString;
use Plugins\CustomAttributes\Models\CustomAttributes;
use Plugins\Product\Contracts\ProductReferenceConfig;

/**
 * Class Product
 * @package Plugins\Product\Models
 */
class Product extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'upc',
        'sku',
        'image_feature',
        'short_description',
        'long_desc',
        'manufacturer_id',
        'is_feature',
        'is_best_seller',
        'is_free_ship',
        'available_3d',
        'is_outdoor',
        'has_assembly',
        'product_dimension',
        'package_dimension',
        'product_weight',
        'package_weight',
        'price',
        'sale_price',
        'inventory',
        'rating',
        'keywords',
        'weight_dimension_description',
        'specification',
        'parent_product_id',
        'type_product',
        'sale_start_date',
        'sale_end_date',
        'created_by',
        'updated_by',
        'status',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_has_sale',
        'percent_sale',
        'min_price',
        'max_price',
        'url_product',
        'has_look_book',
        'was_added_wish_list',
        'was_saved_for_later',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function keywords()
    {
        return $this->hasMany(ProductKeyword::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function productCategories()
    {
        return $this->belongsToMany(ProductCategory::class, 'product_categories_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function productBusinessTypes()
    {
        return $this->belongsToMany(ProductBusinessType::class, 'product_business_types_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function productCollections()
    {
        return $this->belongsToMany(ProductCollection::class, 'product_collections_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function productColors()
    {
        return $this->belongsToMany(ProductColor::class, 'product_colors_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function productMaterials()
    {
        return $this->belongsToMany(ProductMaterial::class, 'product_materials_relation');
    }

    /**
     * Get the product spaces for the product.
     */
    public function productBusinessSpaces()
    {
        return $this->hasMany(ProductBusinessTypeSpaceRelation::class);
    }

    /**
     * Get the product spaces for the product.
     */
    public function productBusiness()
    {
        return $this->belongsToMany(ProductBusinessType::class, 'product_business_type_space_relation', 'product_id', 'business_type_id')
            ->select(['product_business_types.id', 'product_business_types.name as text', 'product_business_types.slug'])->distinct();
    }

    /**
     * Get the product spaces for the product.
     */
    public function productSpaces()
    {
        return $this->belongsToMany(ProductSpace::class, 'product_business_type_space_relation', 'product_id', 'space_id')
            ->select(['product_spaces.id', 'product_spaces.name as text', 'product_spaces.slug'])->distinct();
    }

    /**
     * Get the product custom attributes value relation for the product.
     */
    public function productAttributeValues()
    {
        return $this->hasMany(ProductAttributeValueRelation::class);
    }

    /**
     * Get the product custom attribute for the product.
     */
    public function productCustomAttributes()
    {
        return $this->belongsToMany(CustomAttributes::class, 'product_attribute_value_relations', 'product_id', 'attribute_id')
            ->select(['custom_attributes.*'])->distinct();
    }

    /**
     * Get the product string value attribute for the product.
     */
    public function productStringValueAttribute()
    {
        return $this->belongsToMany(AttributeValueString::class, 'product_attribute_value_relations', 'product_id', 'attribute_value_id')
            ->select(['attribute_value_string.*'])->distinct();
    }

    /**
     * Get the child product of parent the product.
     */
    public function childVariantsProduct()
    {
        return $this->hasMany(Product::class, 'parent_product_id');
    }

    /**
     * Get the parent product of child product.
     */
    public function parentVariantProduct()
    {
        return $this->belongsTo(Product::class, 'parent_product_id');
    }

    /**
     * Get the gallery for the product.
     */
    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productLookBooks()
    {
        return $this->hasMany(LookBookTag::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wishListProducts() {
        return $this->hasMany(WishList::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function saveForLaterProducts() {
        return $this->hasMany(SaveForLater::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return bool
     */
    public function checkProductHasSale() {
        $now = Carbon::now();
        return ($this->sale_price && ($now->lessThan($this->sale_start_date) || $now->greaterThan($this->sale_end_date)));
    }

    /**
     * @return bool
     */
    public function getIsHasSaleAttribute() {
        return $this->checkProductHasSale();
    }

    /**
     * @return float|int
     */
    public function getPercentSaleAttribute() {
        if ($this->sale_price)
            return ceil((1 - ($this->sale_price/$this->price)) * 100);
        return 0;
    }

    /**
     * @return string
     */
    public function getUrlProductAttribute() {
        return "{$this->slug}.{$this->id}";
    }

    /**
     * @return mixed
     */
    public function getMinPriceAttribute() {
        $minPrice = ($this->checkProductHasSale() ? $this->sale_price : $this->price);
        if ($this->type_product === ProductReferenceConfig::PRODUCT_TYPE_VARIANT) {
            $priceChildVariantsProducts = $this->childVariantsProduct()->get();
            foreach ($priceChildVariantsProducts as $priceChildVariantsProduct) {
                $minPrice = ($minPrice > $priceChildVariantsProduct->min_price) ? $priceChildVariantsProduct->min_price : $minPrice;
            }
        }
        return $minPrice;
    }

    /**
     * @return mixed
     */
    public function getMaxPriceAttribute() {
        $maxPrice = $this->price;
        if ($this->type_product === ProductReferenceConfig::PRODUCT_TYPE_VARIANT) {
            $priceChildVariantsProducts = $this->childVariantsProduct()->get();
            foreach ($priceChildVariantsProducts as $priceChildVariantsProduct) {
                $maxPrice = ($maxPrice < $priceChildVariantsProduct->max_price) ? $priceChildVariantsProduct->max_price : $maxPrice;
            }
        }
        return $maxPrice;
    }

    /**
     * @return bool
     */
    public function getHasLookBookAttribute() {
        return $this->productLookBooks->isNotEmpty() ? true : false;
    }

    /**
     * @return bool
     */
    public function getWasAddedWishListAttribute() {
        return (!empty($this->wishListProducts) && Auth::guard('customer')->check()) ? $this->wishListProducts()->where('customer_id', Auth::guard('customer')->id())->exists() : false;
    }

    /**
     * @return bool
     */
    public function getWasSavedForLaterAttribute() {
        return (!empty($this->saveForLaterProducts) && Auth::guard('customer')->check()) ? $this->saveForLaterProducts()->where('customer_id', Auth::guard('customer')->id())->exists() : false;
    }
}
