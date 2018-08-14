<?php
declare( strict_types = 1 );

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use seo_db\Models\Author;

/**
 * Class AuthorRepository
 * @package App\Repositories
 */
class AuthorRepository
{
	/**
	 * @var Author
	 */
	protected $model;

	/**
	 * CategoryRepository constructor.
	 * @param Author $author
	 */
	public function __construct (Author $author)
	{
		$this->model = $author;
	}

	/**
	 * @return Collection
	 */
	public function getForPage () : Collection
	{
		return $this->model::orderBy('first_name')
		                   ->get();
	}
}