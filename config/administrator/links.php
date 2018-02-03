<?php
/**
 * Created by PhpStorm.
 * User: riverside
 * Date: 2018/1/29
 * Time: 20:28
 */

use App\Models\Link;

return [
    'title'   => '资源推荐',
    'single'  => '资源推荐',
    'model'   => Link::class,

    'columns' => [

        'id' => [
            'title' => 'ID',
        ],
        'content' => [
            'title'    => '名称',
            'sortable' => false,
        ],
        'link' => [
            'title'    => '链接',
            'sortable' => false,
        ],
        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'title' => [
            'title'              => '名称',
        ],
        'link' => [
            'title'              => '链接',
        ],
    ],
    'filters' => [
        'id' => [
            'title'              => 'ID',
        ],
        'title' => [
            'title'              => '名称',
        ],
    ],
    'rules'   => [
        'title' => 'required|string',
        'link' => 'required',
    ],
    'messages' => [
        'content.required' => '请填写名称',
        'link.required' => '请填写链接',
    ],
];