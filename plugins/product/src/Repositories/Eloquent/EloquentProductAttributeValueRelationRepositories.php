<?php
/**
 * ProductAttributeValueRelation repository implemented
 */
namespace Plugins\Product\Repositories\Eloquent;
use Illuminate\Support\Facades\DB;
use Plugins\Product\Repositories\Interfaces\ProductAttributeValueRelationRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class EloquentProductAttributeValueRelationRepositories extends RepositoriesAbstract implements ProductAttributeValueRelationRepositories {
    /**
     * @param array $listVariantProductId
     * @param array $whereAttributes
     * @return mixed
     */
    public function getProductsByWhereAttributesOfVariantProduct(array $listVariantProductId, array $whereAttributes) {
        $tableModel = $this->model->getTable();
        $query = DB::table("{$tableModel} as tableModel")
                    ->select('tableModel.product_id')
                    ->whereIn('tableModel.product_id', $listVariantProductId);

        if (!empty($whereAttributes)) {
            $firstAttributes = $whereAttributes[0];
            reset($whereAttributes);
            $query = $query->where("tableModel.attribute_id", $firstAttributes['attribute_id'])
                            ->where("tableModel.attribute_value_id", $firstAttributes['attribute_value_id']);
            foreach ($whereAttributes as $index => $whereAttribute) {
                $query = $query->join("{$tableModel} as tableModel_{$index}", "tableModel.product_id", "=", "tableModel_{$index}.product_id")
                    ->where("tableModel_{$index}.attribute_id", $whereAttribute['attribute_id'])
                    ->where("tableModel_{$index}.attribute_value_id", $whereAttribute['attribute_value_id']);
            }
        }

        return $query->distinct()->pluck('product_id')->toArray();
    }
}