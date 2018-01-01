<?php

function getRouteClass(){
    return str_replace('.','-',Route::currentRouteName());
}