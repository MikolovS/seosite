<?php
declare( strict_types = 1 );

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use seo_db\Models\Post;
use seo_db\Models\Category;

/**
 * Class PostPageRequest
 * @package App\Http\Requests
 * @property Post     $post
 * @property Category $category
 */
class PostPageRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize () : bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules () : array
	{
		return [
			//
		];
	}
}
