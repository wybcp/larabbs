<?php
/**
 * Created by PhpStorm.
 * User: riverside
 * Date: 2018/3/16
 * Time: 11:17
 */

namespace App\Transformers;


use App\Models\Link;
use League\Fractal\TransformerAbstract;

class LinkTransformer extends TransformerAbstract
{
    public function transform(Link $link)
    {
        return [
            'id'    => $link->id,
            'title' => $link->title,
            'link'  => $link->link,
        ];

    }

}