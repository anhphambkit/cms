<?php
namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use BFileService;
use Carbon\Carbon;

class InventoryController extends BaseAdminController
{
    /**
     * @var ProductRepositories
     */
    protected $productRepository;

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
        return $this->arrayToCsvDownload($items, "inventory-{$timeline}.csv");
    }

    /**
     * import
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        //TODO
    }

    /** 
     * [array_to_csv_download description]
     * @param  [type] $items     [description]
     * @param  string $filename  [description]
     * @param  string $delimiter [description]
     * @return [type]            [description]
     */
    protected function arrayToCsvDownload($items, $filename = "export.csv") 
    {
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        $f = @fopen( 'php://output', 'w' );

        foreach ($items as $line) {
            fputcsv($f, $line);
        }
        fclose($f);
        die;
    }   
}