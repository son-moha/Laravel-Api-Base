<?php

namespace Modules\Core\Entities\Resources;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Core\Constants\AppConst;
use Modules\Core\Constants\HttpStatus;

class BaseApiResponse extends JsonResource
{
    /**
     * @param $resource
     *
     * @return \Illuminate\Http\JsonResponse|AnonymousResourceCollection
     */
    public static function collection($resource)
    {
        if ($resource instanceof LengthAwarePaginator) {
            return response()->json([
                'data'   => [
                    'items' => parent::collection($resource->collect()),
                    'links' => $resource->linkCollection(),
                    'meta' => [
                        "current_page" => $resource->currentPage(),
                        "last_page"    => $resource->lastPage(),
                        "path"         => $resource->path(),
                        "per_page"     => $resource->perPage(),
                        "total"        => $resource->total()
                    ]
                ],
                'status' => AppConst::SUCCESS
            ]);
        }

        return parent::collection($resource)->additional(['status' => AppConst::SUCCESS]);
    }

    public function with($request)
    {
        return ['status' => AppConst::SUCCESS];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param \Illuminate\Http\Request
     * @param \Illuminate\Http\Response
     * @return void
     */
    public function withResponse($request, $response)
    {
        /**
         * Not all prerequisites were met.
         */
        $response->setStatusCode(HttpStatus::STATUS_200, 'OK');
    }
}
