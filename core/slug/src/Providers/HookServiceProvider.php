<?php

namespace Core\Slug\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Boot the service provider.
     * @author TrinhLe
     */
    public function boot()
    {
        add_filter(BASE_FILTER_SLUG_AREA, [$this, 'addSlugBox'], 17, 3);

        add_filter(BASE_FILTER_BEFORE_GET_FRONT_PAGE_ITEM, [$this, 'getItemSlug'], 3, 3);
    }

    /**
     * @param $screen
     * @param $object
     * @param null $prefix
     * @return null|string
     * @throws \Throwable
     * @author TrinhLe
     */
    public function addSlugBox($screen, $object = null)
    {
        if (in_array($screen, config('core-slug.general.supported'))) {
            $prefix = Arr::get(config('core-slug.general.prefixes', []), $screen, '');
            return view('core-slug::partials.slug', compact('object', 'screen', 'prefix'))->render();
        }
        return null;
    }

    /**
     * @param Builder $data
     * @param Model $model
     * @param string $screen
     * @return mixed
     * @author TrinhLe
     */
    public function getItemSlug($data, $model, $screen = null)
    {
        return $data;
        
        if (!empty($screen) &&
            in_array($screen, config('core-slug.general.supported')) &&
            method_exists($model, 'getScreen') &&
            $screen == $model->getScreen()
        ) {
            $table = $model->getTable();
            $select = [$table . '.*'];
            /**
             * @var \Eloquent $data
             */
            $rawBindings = $data->getRawBindings();
            /**
             * @var \Eloquent $rawBindings
             */
            $query = $rawBindings->getQuery();
            if ($query instanceof Builder) {
                $querySelect = $data->getQuery()->columns;
                if (!empty($querySelect)) {
                    $select = $querySelect;
                }
            }

            foreach ($select as &$column) {
                if (strpos($column, '.') === false) {
                    $column = $table . '.' . $column;
                }
            }

            $select = array_merge($select, ['slugs.key']);

            return $data
                ->leftJoin('slugs', function (JoinClause $join) use ($table) {
                    $join->on('slugs.reference_id', '=', $table . '.id');
                })
                ->select($select)
                ->where('slugs.reference', '=', $model->getScreen());
        }

        return $data;
    }
}
