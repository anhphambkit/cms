<?php

namespace Plugins\Product\Services;

use Plugins\Product\Models\Product;
use Plugins\Product\Models\ProductKeyword;
use Illuminate\Http\Request;
use Carbon\Carbon;
class StoreKeywordService
{
    /**
     * [execute description]
     * @param  Request $request [description]
     * @param  Product $product [description]
     */
    public function execute(Request $request, Product $product)
    {
        $keywords = $product->keywords()->get()->pluck('name')->all();
        if (implode(',', $keywords) !== $request->input('keywords')) {
            ProductKeyword::where('product_id', $product->id)->delete();
            $tagInputs = explode(',', $request->input('keywords'));
            foreach ($tagInputs as $tagName) {
                if (!trim($tagName)) {
                    continue;
                }
                $items[] = [
                    'product_id' => $product->id,
                    'name'       => $tagName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            ProductKeyword::insert($items ?? []);
        }
    }
}
