<?php

namespace App\Http\Controllers;

use App\Transformers\UserTransformer;
use Dingo\Api\Routing\Helpers;

class ApiController extends Controller
{
    use Helpers;

    /**
     * @param $data
     * @param $transformer
     *
     * @return \Dingo\Api\Http\Response
     */
    public function respond($data, $transformer)
    {
        return $data;
        if (count($data) == 1) {
            return $this->response->item($data, $transformer);
        }

        return $this->response->collection($data, $transformer);
    }

    /**
     * @return mixed data
     */
    public function getUser()
    {
        return $this->respond(app('Dingo\Api\Auth\Auth')->user(), new UserTransformer());
    }

    /**
     * @return User
     */
    protected function user()
    {
        return app('Dingo\Api\Auth\Auth')->user();
    }
}
