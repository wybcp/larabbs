<?php
/**
 * Created by PhpStorm.
 * User: riverside
 * Date: 2018/3/16
 * Time: 10:14
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Role;

class RoleTransformer extends TransformerAbstract
{
    public function transform(Role $role)
    {
        return [
            'id'=>$role->id,
            'name'=>$role->name,
        ];

    }

}