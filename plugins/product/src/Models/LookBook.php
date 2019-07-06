<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-20
 * Time: 08:25
 */

namespace Plugins\Product\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class LookBook extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'look_books';

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'image',
        'permalink',
        'type_layout',
        'is_main',
        'created_by',
        'updated_by',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'look_book_all_spaces',
        'look_book_all_business',
        'slug_link',
        'was_added_wish_list',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the look book tags for the look book.
     */
    public function lookBookTags()
    {
        return $this->hasMany(LookBookTag::class);
    }

    /**
     * Get the look book product for the look book.
     */
    public function lookBookProducts()
    {
        return $this->belongsToMany(Product::class, 'look_book_tags')->whereNull('look_book_tags.deleted_at');
    }

    /**
     * Get the look book spaces for the look book.
     */
    public function lookBookSpaces()
    {
        return $this->hasMany(LookBookBusinessTypeSpaceRelation::class);
    }

    /**
     * Get the look book spaces for the look book.
     */
    public function lookBookBusiness()
    {
        return $this->belongsToMany(ProductBusinessType::class, 'look_book_business_type_space_relation', 'look_book_id', 'business_type_id')
            ->select(['product_business_types.id', 'product_business_types.name as text', 'product_business_types.slug'])->distinct();
    }

    /**
     * Get the look book spaces for the look book.
     */
    public function lookBookSpacesBelong()
    {
        return $this->belongsToMany(ProductSpace::class, 'look_book_business_type_space_relation', 'look_book_id', 'space_id')
            ->select(['product_spaces.id', 'product_spaces.name as text', 'product_spaces.slug'])->distinct();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function wishListLookBooks() {
        return $this->morphMany(WishList::class, 'entity');
    }

    /**
     * @return string
     */
    public function getLookBookAllSpacesAttribute()
    {
        $result = "";
        foreach ($this->lookBookSpacesBelong as $index => $space) {
            $result .= "{$space->text}";
            if ($index < ($this->lookBookSpacesBelong->count() - 1))
                $result .= ", ";
        }
        return trim($result);
    }

    /**
     * @return string
     */
    public function getLookBookAllBusinessAttribute()
    {
        $result = "";
        foreach ($this->lookBookBusiness as $index => $businessType) {
            $result .= "{$businessType->text}";
            if ($index < ($this->lookBookBusiness->count() - 1))
                $result .= ", ";
        }
        return trim($result);
    }

    /**
     * @return string
     */
    public function getSlugLinkAttribute()
    {
        $slug = str_slug($this->name);
        return "{$slug}.{$this->id}";
    }

    /**
     * @return bool
     */
    public function getWasAddedWishListAttribute() {
        return (!empty($this->wishListLookBooks) && Auth::guard('customer')->check()) ? $this->wishListLookBooks()->where('customer_id', Auth::guard('customer')->id())->exists() : false;
    }
}