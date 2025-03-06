<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait QuerySearch
{
    /**
     * Applique les filtres de recherche à la requête.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $search
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected static function bootQuerySearch()
    {

        static::addGlobalScope('querySearch', function (Builder $query) {
            $request = request();

            if($request->has('search')){
                $search = trim($request->get('search'));

                /** @var \Illuminate\Database\Eloquent\Model $model */
                $model = new static();
                $columns = $model->searchable ?? [];

                if (!empty($columns)) {
                    $keywords = explode(' ', $search);

                    $query->where(function (Builder $q) use ($keywords, $columns) {
                        foreach ($columns as $column) {
                            $q->orWhere(function (Builder $subQuery) use ($column, $keywords) {
                                foreach ($keywords as $keyword) {
                                    $subQuery->orWhere($column, 'LIKE', "%{$keyword}%");
                                }
                            });
                        }
                    });
                }
            }
        });
    }
}
