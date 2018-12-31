<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionMacrosServiceProvider extends ServiceProvider
{
    /**
     * Laravel Collection helpers don't provide sorting by multiple column
     * I did not write these macros, found them here: https://www.jjanusch.com/2017/05/laravel-collection-macros-adding-a-sortbymuti-function
     *
     * @return void
     */
    public function boot()
    {
        if (!Collection::hasMacro('ungroup')) {
            Collection::macro('ungroup', function () {
                // create a new collection to use as the collection where the other collections are merged into
                $newCollection = Collection::make([]);
                // $this is the current collection ungroup() has been called on
                // binding $this is common in JS, but this was the first I had run across it in PHP
                $this->each(function ($item) use (&$newCollection) {
                    // use merge to combine the collections
                    $newCollection = $newCollection->merge($item);
                });

                return $newCollection;
            });
        }

        if (!Collection::hasMacro('sortByMulti')) {
            Collection::macro('sortByMulti', function (array $keys) {
                $currentIndex = 0;
                $keys = array_map(function ($key, $sort) {
                    return ['key' => $key, 'sort' => $sort];
                }, array_keys($keys), $keys);

                $sortBy = function (Collection $collection) use (&$currentIndex, $keys, &$sortBy) {
                    if ($currentIndex >= count($keys)) {
                        return $collection;
                    }

                    $key = $keys[$currentIndex]['key'];
                    $sort = $keys[$currentIndex]['sort'];
                    $sortFunc = $sort === 'DESC' ? 'sortByDesc' : 'sortBy';
                    $currentIndex++;
                    return $collection->$sortFunc($key)->groupBy($key)->map($sortBy)->ungroup();
                };

                return $sortBy($this);
            });
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
