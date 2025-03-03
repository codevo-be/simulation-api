<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait AutoloadRelationships
{
    protected static function bootAutoloadRelationships()
    {
        static::addGlobalScope('autoloadRelations', function (Builder $query) {
            $request = request();

            if ($request->has('include')) {
                $relations = explode(',', $request->query('include'));

                if (!empty($relations)) {
                    $query->with($relations);
                }
            }
        });
    }
}

