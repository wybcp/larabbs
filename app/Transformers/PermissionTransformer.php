<?php
/**
 * Created by PhpStorm.
 * User: riverside
 * Date: 2018/3/15
 * Time: 17:19
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Permission;

class PermissionTransformer extends TransformerAbstract
{
    public function transform(Permission $permission)
    {
        return [
            'id'   => $permission->id,
            'name' => $permission->name,
        ];

    }

}