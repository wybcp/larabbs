<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Link;
use App\Transformers\LinkTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class LinksController extends Controller
{
    public function index(Link $link)
    {
        $links = $link->getAllCached();

        return $this->response->collection($links, new LinkTransformer());

    }
}
