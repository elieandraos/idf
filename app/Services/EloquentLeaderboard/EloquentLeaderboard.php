<?php
namespace App\Services\EloquentLeaderboard;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class EloquentLeaderboard 
{
	protected $collection;

	public function __construct(EloquentCollection $collection)
	{
		$this->collection = $this->handleCollection($collection);
	}

	/**
	 * In case we want to manipulate the collection when constructing the child class
	 * 
	 * @param EloquentCollection $collection 
	 * @return Collection
	 */
	public function handleCollection(EloquentCollection $collection) : Collection
	{
		return $collection;
	}

	/**
	 * Return the collection tho the child class
	 * 
	 * @return Collection
	 */
	public function getCollection() : Collection
	{
		return $this->collection;
	}

	/**
	 * Default chunk size, can be overriden in child class
	 * 
	 * @return int
	 */
	public function getChunkSize() : int 
	{
		return 3;
	}
}