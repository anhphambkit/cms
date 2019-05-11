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
        return $this->belongsToMany(ProductBusinessType::class, 'look_book_business_type_space_relation', 'look_book_id', 'business_type_id');
    }

    /**
     * Get the look book spaces for the look book.
     */
    public function lookBookSpacesBelong()
    {
        return $this->belongsToMany(ProductSpace::class, 'look_book_business_type_space_relation', 'look_book_id', 'space_id');
    }
}