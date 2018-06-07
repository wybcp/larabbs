<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use App\Transformers\CategoryTransformer;
use App\Http\Controllers\Api\Controller;

class CategoriesController extends Controller
{
    public function index()
    {
        return $this->response->collection(Category::all(),new CategoryTransformer());
    }
}
