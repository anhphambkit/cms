<?php
namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Plugins\Product\Requests\InventoryRequest;
use Core\Base\Responses\BaseHttpResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use BFileService;
use Illuminate\Support\Facades\DB;

class ProductKeywordController extends BaseAdminController
{
    const PRODUCT_ID      = "PRODUCT_ID";
    const PRODUCT_SKU     = "PRODUCT_SKU";
    const PRODUCT_NAME    = "PRODUCT_NAME";
    const PRODUCT_KEYWORD = "PRODUCT_KEYWORD";

    /** 
     * @var array
     */
    protected $headers = array();

    /**
     * @var array
     */
    protected $mappingColumns = [
        self::PRODUCT_ID      => 'Product ID',
        self::PRODUCT_SKU     => 'Product SKU',
        self::PRODUCT_NAME    => 'Product Name',
        self::PRODUCT_KEYWORD => 'Keyword',
    ];

    /**
     * ProductController constructor.
     * @param ProductRepositories $productRepository
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * export
     * @return \Illuminate\Http\JsonResponse
     */
    public function export($id, Request $request)
    {
        //TODO
        $keywords = DB::table('products')
                ->select('products.id', 'products.sku', 'products.name as product_name', 'product_keywords.name as keyword')
                ->leftJoin('product_keywords', 'products.id', '=', 'product_keywords.product_id')
                ->where('products.id', (int)$id)
                ->get();

        $items[] = array('Product ID','Product SKU', 'Product Name', 'Keyword');
        foreach ($keywords as $key => $keyword) {
            # code...
            $items[] = [
                $keyword->id,
                $keyword->sku,
                $keyword->product_name,
                $keyword->keyword
            ];
        }
        $timeline = Carbon::now()->toDateTimeString();
        return BFileService::arrayToCsvDownload($items, "product-{$id}-keyword-{$timeline}.csv");
    }

    /**
     * import
     * @return \Illuminate\Http\JsonResponse
     */
    public function import($id, InventoryRequest $request, BaseHttpResponse $response)
    {
        $file     = $request->file('csv');
        $isHeader = true;
        \BFileService::readCsvFile($file->getRealPath(), function($row, $lineNumber) use(&$isHeader, &$items){
            if($isHeader) {
                $this->headers = BFileService::generateColumnNumberHeader($this->mappingColumns, $row);
                return $isHeader = false;
            }

            foreach ($this->headers as $column => $index) {
                # code...
                $formatRow[$column] = $row[$index] ?? null;
            }

            if($formatRow[self::PRODUCT_KEYWORD]){
                $items[] = [
                    'product_id' => $formatRow[self::PRODUCT_ID],
                    'name'       => $formatRow[self::PRODUCT_KEYWORD],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            # reset memory data
            $formatRow = null;
        });
        
        DB::table('product_keywords')->where('product_id', (int)$id)->delete();
        DB::table('product_keywords')->insert($items ?? []);
        return $response
                ->setMessage(trans('Import keyword success.'));
            
    }
}