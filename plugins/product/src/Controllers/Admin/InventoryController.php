<?php
namespace Plugins\Product\Controllers\Admin;

use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Core\Base\Controllers\Admin\BaseAdminController;
use Plugins\Product\Requests\InventoryRequest;
use Core\Base\Responses\BaseHttpResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use BFileService;

class InventoryController extends BaseAdminController
{
    const PRODUCT_ID        = "PRODUCT_ID";
    const PRODUCT_SKU       = "PRODUCT_SKU";
    const PRODUCT_NAME      = "PRODUCT_NAME";
    const PRODUCT_INVENTORY = "PRODUCT_INVENTORY";

    /**
     * @var ProductRepositories
     */
    protected $productRepository;

    /** 
     * @var array
     */
    protected $headers = array();

    /**
     * @var array
     */
    protected $mappingColumns = [
        self::PRODUCT_ID        => 'Product ID',
        self::PRODUCT_SKU       => 'Product SKU',
        self::PRODUCT_NAME      => 'Product Name',
        self::PRODUCT_INVENTORY => 'Inventory',
    ];

    /**
     * ProductController constructor.
     * @param ProductRepositories $productRepository
     */
    public function __construct(ProductRepositories $productRepository)
    {
        $this->productRepository = $productRepository;
        parent::__construct();
    }

    /**
     * export
     * @return \Illuminate\Http\JsonResponse
     */
    public function export(Request $request)
    {
        //TODO
        $products = $this->productRepository->all();
        $headers = array('Product ID','Product SKU', 'Product Name', 'Inventory');
        $items[] = $headers;
        foreach ($products as $key => $product) {
            # code...
            $items[] = [
                $product->id,
                $product->sku,
                $product->name,
                $product->inventory
            ];
        }
        $timeline = Carbon::now()->toDateTimeString();
        return BFileService::arrayToCsvDownload($items, "inventory-{$timeline}.csv");
    }

    /**
     * import
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(InventoryRequest $request, BaseHttpResponse $response)
    {
        $file     = $request->file('csv');
        $isHeader = true;
        \BFileService::readCsvFile($file->getRealPath(), function($row, $lineNumber) use(&$isHeader){
            if($isHeader) {
                $this->headers = BFileService::generateColumnNumberHeader($this->mappingColumns, $row);
                return $isHeader = false;
            }

            foreach ($this->headers as $column => $index) {
                # code...
                $formatRow[$column] = $row[$index] ?? null;
            }

            # Insert inventory here
            $this->productRepository->update([
                'id' => (int)$formatRow[self::PRODUCT_ID]
            ],[
                'inventory' => (int)$formatRow[self::PRODUCT_INVENTORY]
            ]);

            # reset memory data
            $formatRow = null;
        });

        return $response
                ->setMessage(trans('Import inventory success.'));
            
    }
}