<?php

namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Exception;

trait HasSearch
{
    public function scopeSearch(Builder $builder, string $term = '', $force = true)
    {
        if (!$this->searchable) {
            throw new Exception("Please define the searchable property . ");
        }

        $builder->where(function ($query) use ($term, $force) {
            $terms = explode(' ', $term);
            foreach ($terms as $word) {
                $query->{$force ? 'where' : 'orWhere'}(function ($query) use ($word) {
                    foreach ($this->searchable as $searchable) {
                        if (Str::contains($searchable, '.')) {
                            $relation = Str::beforeLast($searchable, '.');
                            $column = Str::afterLast($searchable, '.');
                            $query->orWhereHas($relation, function ($subQuery) use ($column, $word) {
                                $subQuery->where($column, 'like', "%$word%");
                            });
                        } else {
                            $query->orWhere($searchable, 'like', "%$word%");
                        }
                    }
                });
            }
        });

        return $builder;
    }
}
