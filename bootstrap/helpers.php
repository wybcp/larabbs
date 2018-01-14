<?php

function getRouteClass(){
    return str_replace('.','-',Route::currentRouteName());
}

/**
 * 根据topic内容提取摘要
 * @param     $value
 * @param int $length
 * @return string
 */
function makeExcerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}