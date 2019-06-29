<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-04
 * Time: 13:53
 */

namespace Core\Base\Traits;

use Carbon\Carbon;

trait ParseFilterSearch
{
    /**
     * @var array conditions special.
     */
    protected $signalFilters = [
        'LIKE',
        'ILIKE'
    ];

    protected $defaultLimit = 12;

    /**
     * @param array $filters
     * @return array
     */
    protected function getDataPageLoad(array $filters = []){
        $mappingColumns =  property_exists($this, 'mappingColumns') ? $this->mappingColumns : [];
        $defaultPage =  property_exists($this, 'defaultPage') ? $this->defaultPage : null;

        $sortOrder = property_exists($this, 'defaultSortOrder') ? $this->defaultSortOrder : null;
        $orderBy = property_exists($this, 'defaultOrderBy') ? $this->defaultOrderBy : null;

        if (isset($filters['sortOrder']) && !empty($filters['sortOrder'])) {
            $sortOrder = ($filters['sortOrder'] === 'desc' ? 'desc' : 'asc');
        }
        if (isset($filters['orderBy']) && !empty($filters['orderBy'])) {
            $orderBy = (isset($mappingColumns[$filters['orderBy']]) && !empty($mappingColumns[$filters['orderBy']])) ? $mappingColumns[$filters['orderBy']] : null;
        }
        return [
            'page'  => empty($filters['page']) ? $defaultPage : intval($filters['page']),
            'limit' => empty($filters['limit']) ? $this->defaultLimit : intval($filters['limit']),
            'orderBy' => $orderBy,
            'sortOrder' => $sortOrder
        ];
    }

    /**
     * @param $query
     * @param array $dataPageLoad
     * @return array
     */
    protected function getResultSearchWithDataPageLoad($query, array $dataPageLoad = [])
    {
        $count = clone $query;

        if (!empty($dataPageLoad['orderBy'])) {
            $query = $query->orderBy($dataPageLoad['orderBy'], $dataPageLoad['sortOrder']);
        }

        if(empty($dataPageLoad['page']))
            return [
                'data'  => $query->distinct()->get(),
                'count' => $count->distinct()->count()
            ];

        $offset = ($dataPageLoad['page']<2) ? 0 : ($dataPageLoad['page']-1)*$dataPageLoad['limit'];
        return [
            'data'  => $query->offset($offset)->limit($dataPageLoad['limit'])->distinct()->get(),
            'count' => $count->distinct()->count()
        ];
    }

    /**
     * @param $query
     * @param array $filters
     * @param string $key
     * @return array
     */
    protected function getResultSearchWithDataPageLoadCollection($query, array $filters = [], string $key = 'get'){
        $mappingColumns =  property_exists($this, 'mappingColumns') ? $this->mappingColumns : [];

        $count = clone $query;
        $data = $query->distinct()->get();

        $function = $key. 'CollectionData';
        !method_exists($this,$function) ? : $this->$function($data);

        $orderBy = property_exists($this, 'defaultOrderBy') ? $this->defaultOrderBy : null;
        if (isset($filters['orderBy']) && !empty($filters['orderBy'])) {
            $orderBy = (isset($mappingColumns[$filters['orderBy']]) && !empty($mappingColumns[$filters['orderBy']])) ? $mappingColumns[$filters['orderBy']] : null;
        }

        $sortOrder = !empty($filters['sortOrder']) ? $filters['sortOrder'] : (property_exists($this, 'defaultSortOrder') ? $this->defaultSortOrder : null);
        if (!empty($sortOrder) && !empty($orderBy)) {
            $data = ($sortOrder === 'desc') ? $data->sortByDesc($orderBy) : $data->sortBy($orderBy);
        }

        if (!empty($filters['page']) && !empty($filters['limit'])) {
            $data = $data->forPage(intval($filters['page']), intval($filters['limit']));
        }
        else if (!empty($filters['limit']))
            $data = $data->take(intval($filters['limit']));

        return [
            'data'  => $data,
            'count' => $count->count()
        ];
    }

    /**
     * @param array $filters
     * @return array
     */
    protected function getFilterAjaxSearch(array $filters = []){
        $page = empty($filters['page']) ? 0 : intval($filters['page']);
        $limit = empty($filters['limit']) ? 0 : intval($filters['limit']);
        $offset = ($page<2) ? 0 : ($page-1)*$limit;
        $searchKey = empty($filters['searchKey']) ? null : trim($filters['searchKey']);
        return [
            'page'  => $page,
            'offset'  => $offset,
            'limit'  => $limit,
            'search_key' => $searchKey,
        ];
    }

    /**
     * @param $currentModel
     * @param $query
     * @param array $request
     * @param string $key
     * @return array
     */
    public function getDataPageLoadDataTable($currentModel, $query, array $request = [], string $key = '') {
        $mappingColumns =  property_exists($this, 'mappingColumns') ? $this->mappingColumns : [];
        $searchOptions =  property_exists($this, 'searchOptions') ? $this->searchOptions : [];

        $draw = (int)$request['draw'];
        $start = (int)$request['start'];
        $limit = (int)$request['length'];
        $searchValue = trim($request['search']['value']);
        $searchRegex = $request['search']['regex'];

        // Get array columns order able and search able
        $requestColumns = $request['columns'];
        $orderAbleColumns = [];
        $searchColumns = [];
        $searchAbleColumns = [];
        foreach ($requestColumns as $keyColumn => $requestColumn) {
            if (($requestColumn['orderable'] === "true" || $requestColumn['orderable'] === "1") && array_search((!empty($requestColumn['name']) ? $requestColumn['name'] : $requestColumn['data']), $mappingColumns) !== false)
                array_push($orderAbleColumns, array_search((!empty($requestColumn['name']) ? $requestColumn['name'] : $requestColumn['data']), $mappingColumns));

            if (($requestColumn['searchable'] === "true" || $requestColumn['searchable'] === "1") && array_search((!empty($requestColumn['name']) ? $requestColumn['name'] : $requestColumn['data']), $mappingColumns) !== false) {
                if (!empty($requestColumn['search']['value']))
                    array_push($searchColumns, [
                        'id' => array_search((!empty($requestColumn['name']) ? $requestColumn['name'] : $requestColumn['data']), $mappingColumns),
                        'value' => $requestColumn['search']['value'],
                        'search_regex' => $requestColumn['search']['regex'],
                    ]);
                array_push($searchAbleColumns, array_search((!empty($requestColumn['name']) ? $requestColumn['name'] : $requestColumn['data']), $mappingColumns));
            }
        }

        // Get array order columns:
        $orders = [];
        $requestOrders = $request['order'];
        foreach ($requestOrders as $keyRequestOrder => $requestOrder) {
            if (in_array((int)$requestOrder['column'], $orderAbleColumns))
                $orders[$requestOrder['column']] = $requestOrder['dir'];
        }

        $whereConditions = $orWhereConditions = [];
        // Get array where conditions and orWhere conditions:
        if (!empty($searchValue)) {
            $isWhereSearch = true;
            foreach ($searchAbleColumns as $keySearchAbleColumn => $searchAbleColumn) {
                if (isset($mappingColumns[$searchAbleColumn]) && isset($searchOptions["$key"][$mappingColumns[$searchAbleColumn]])) {
                    $columnSearch = $searchOptions["$key"][$mappingColumns[$searchAbleColumn]]['column'];
                    $typeSearch = $searchOptions["$key"][$mappingColumns[$searchAbleColumn]]['search_type'];
                    $operatorSearch = $searchOptions["$key"][$mappingColumns[$searchAbleColumn]]['operator'];
                    $condition = [];
                    switch ($typeSearch) {
                        case 'string':
                            if (!empty($searchValue)) {
                                $valueSearch = $searchValue;
                                if ($operatorSearch === "ILIKE" || $operatorSearch === "LIKE")
                                    $valueSearch = "%{$searchValue}%";
                                $condition = [
                                    $columnSearch, $operatorSearch, $valueSearch
                                ];
                            }
                            break;
                        case 'int':
                            $condition = [
                                $columnSearch, $operatorSearch, (int)$searchValue
                            ];
                            break;
                        case 'bool':
                            $condition = [
                                $columnSearch, $operatorSearch, (bool)$searchValue
                            ];
                            break;
                        case 'date':
                            $searchValue = format_date_time(trim($searchValue), $searchOptions["$key"][$mappingColumns[$searchAbleColumn]]['date_options']['timezone'], $searchOptions["$key"][$mappingColumns[$searchAbleColumn]]['date_options']['format_input'], $searchOptions["$key"][$mappingColumns[$searchAbleColumn]]['date_options']['format_output']);
                            $condition = [
                                $columnSearch, $operatorSearch, $searchValue
                            ];
                            break;
                    }
                    if (!empty($condition)) {
                        if ($isWhereSearch)
                            array_push($whereConditions, $condition);
                        else
                            array_push($orWhereConditions, $condition);
                    }
                    $isWhereSearch = false;
                }
            }
        }

        // Add where search
        if (!empty($whereConditions))
            $query = $query->where($whereConditions);

        // Add orWhere search:
        foreach ($orWhereConditions as $orWhereCondition) {
            $query = $query->orWhere([$orWhereCondition]);
        }

        // Parse order query:
        foreach ($orders as $keyOrder => $order) {
            $columnOrder = $searchOptions["$key"][$mappingColumns[$keyOrder]]['column'];
            $query = $query->orderBy($columnOrder, $order);
        }

        $queryCount = clone $query;
        $data = $query->offset($start)->limit($limit)->get();
        $totalFiltered = $queryCount->count();
        $totalData = $currentModel->count();
        return [
            "draw"            => $draw,
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ];
    }

    /**
     * @param $query
     * @param array $filters
     * @param string $key
     * @return array
     */
    protected function parseFilters(&$query, $filters = [], $key = '')
    {
        $searchOptions =  property_exists($this, 'searchOptions') ? $this->searchOptions : [];

        $searchFilters = [];
        if(!empty($filters)){
            if(!empty($searchOptions["$key"]))
            {
                $searchConditions = $searchOptions["$key"];
                foreach($searchConditions as $keyFilter => $searchCondition)
                {
                    if(isset($filters["$keyFilter"]))
                    {
                        $condition = [];
                        switch ($searchCondition['search_type']) {
                            case 'string':
                                $valueRequestFormat = trim($filters["$keyFilter"]);
                                if (!empty($valueRequestFormat)) {
                                    $valueSearch = $valueRequestFormat;
                                    if ($searchCondition['operator'] === "ILIKE" || $searchCondition['operator'] === "LIKE")
                                        $valueSearch = "%{$valueRequestFormat}%";
                                    $condition = [
                                        $searchCondition['column'], $searchCondition['operator'], $valueSearch
                                    ];
                                }
                                break;
                            case 'int':
                                $condition = [
                                    $searchCondition['column'], $searchCondition['operator'], (int)$filters["$keyFilter"]
                                ];
                                break;
                            case 'bool':
                                $condition = [
                                    $searchCondition['column'], $searchCondition['operator'], (bool)$filters["$keyFilter"]
                                ];
                                break;
                            case 'date':
                                $valueRequestFormat = format_date_time(trim($filters["$keyFilter"]), $searchCondition['date_options']['timezone'], $searchCondition['date_options']['format_input'], $searchCondition['date_options']['format_output']);
                                $condition = [
                                    $searchCondition['column'], $searchCondition['operator'], $valueRequestFormat
                                ];
                                break;
                        }
                        if (!empty($condition))
                            array_push($searchFilters, $condition);

                        if (!empty($searchCondition['join_table'])) {
                            switch ($searchCondition['join_table']['type_join']) {
                                case 'left':
                                    $query = $query->leftJoin($searchCondition['join_table']['table'], $searchCondition['join_table']['join_condition_left'], '=', $searchCondition['join_table']['join_condition_right']);
                                    break;
                                case 'right':
                                    $query = $query->rightJoin($searchCondition['join_table']['table'], $searchCondition['join_table']['join_condition_left'], '=', $searchCondition['join_table']['join_condition_right']);
                                    break;
                            }
                        }
                    }
                }
            }

            // Parse where filter time:
            $this->parseFilterTime($query, $filters);
        }

        try{
            $function = $key. 'AfterParseSearchFilters';
            !method_exists($this,$function) ? : $this->$function($filters, $searchFilters);
        }catch(\Exception $ex)
        {
            //Nothing
        }

        return $searchFilters;
    }

    /**
     * @param $query
     * @param array $filters
     */
    public function parseFilterTime(&$query, $filters = []) {
        $columnFilterTime =  property_exists($this, 'columnFilterTime') ? $this->columnFilterTime : config('core-base.search-filter.column_filter_time');
        $keyFilterTime = property_exists($this, 'keyFilterTime') ? $this->keyFilterTime : config('core-base.search-filter.key_filter_time');
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        Carbon::setWeekEndsAt(Carbon::SUNDAY);
        if (isset($filters["$keyFilterTime"])) {
            switch ($filters["$keyFilterTime"]) {
                case config('core-base.search-filter.time_filter.today'):
                    $query = $query->whereDate($columnFilterTime, Carbon::today());
                    break;
                case config('core-base.search-filter.time_filter.yesterday'):
                    $query = $query->whereDate($columnFilterTime, Carbon::yesterday());
                    break;
                case config('core-base.search-filter.time_filter.this_week'):
                    $startOfWeek = Carbon::now()->startOfWeek();
                    $endOfWeek = Carbon::now()->endOfWeek();
                    $query = $query->whereBetween($columnFilterTime, [$startOfWeek, $endOfWeek]);
                    break;
                case config('core-base.search-filter.time_filter.last_week'):
                    $startOfWeek = Carbon::now()->startOfWeek()->subWeek();
                    $endOfWeek = Carbon::now()->endOfWeek()->subWeek();
                    $query = $query->whereBetween($columnFilterTime, [$startOfWeek, $endOfWeek]);
                    break;
                case config('core-base.search-filter.time_filter.this_month'):
                    $query = $query->whereMonth($columnFilterTime, Carbon::now()->month);
                    break;
                case config('core-base.search-filter.time_filter.last_month'):
                    $startOfMonth = Carbon::now()->startOfMonth()->subMonth();
                    $endOfMonth = Carbon::now()->endOfWeek()->subMonth();
                    $query = $query->whereBetween($columnFilterTime, [$startOfMonth, $endOfMonth]);
                    break;
                case config('core-base.search-filter.time_filter.this_year'):
                    $query = $query->whereYear($columnFilterTime, Carbon::now()->year);
                    break;
                case config('core-base.search-filter.time_filter.other'):
                    $keyFilterStartRangeTime = property_exists($this, 'keyFilterStartRangeTime') ? $this->keyFilterStartRangeTime : config('core-base.search-filter.key_filter_start_range_date');
                    $keyFilterEndRangeTime = property_exists($this, 'keyFilterEndRangeTime') ? $this->keyFilterEndRangeTime : config('core-base.search-filter.key_filter_end_range_date');
                    $query = $query->whereBetween($columnFilterTime, [$filters["$keyFilterStartRangeTime"], $filters["$keyFilterEndRangeTime"]]);
                    break;
            }
        }
    }
}
