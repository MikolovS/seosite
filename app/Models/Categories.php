<?php
declare( strict_types = 1 );

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Class Categories
 * @package App\Models
 */
class Categories extends Model
{
    use NodeTrait;

    protected $fillable = [
    	'name',
	    'slug',
	    '_lft',
	    '_rgt',
	    'parent_id',
    ];
}
