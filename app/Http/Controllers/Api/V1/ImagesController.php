<?php

namespace App\Http\Controllers\Api\V1;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\Api\ImageRequest;
use App\Models\Image;
use App\Http\Controllers\Api\Controller;
use App\Transformers\ImageTransformer;
use function str_plural;

class ImagesController extends Controller
{
    public function store(Image $image, ImageRequest $request, ImageUploadHandler $handler)
    {
        $user = $this->user();
        $size = $request->type === 'avatar' ? 362 : 1024;
        $result = $handler->save($request->image, str_plural($request->type), $user->id, $size);

        $image->path = $result['path'];
        $image->type = $request->type;
        $image->user_id = $user->id;
        $image->save();
        
        return $this->response->item($image, new ImageTransformer())->setStatusCode(201);
    }
}
