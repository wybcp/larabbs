<?php
/**
 * Created by PhpStorm.
 * User: riverside
 * Date: 2018/3/9
 * Time: 16:49
 */

namespace App\Transformers;


use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        return [
          'id'=>$category->id,
          'name'=>$category->name,
          'description'=>$category->description,
        ];
    }
}