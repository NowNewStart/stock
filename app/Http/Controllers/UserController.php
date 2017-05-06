<?php

namespace App\Http\Controllers;

use App\User;
use Dingo\Api\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class UserController extends Controller
{
    /**
     * @var JWTAuth
     */
    protected $auth;

    /**
     * @param JWTAuth $auth
     */
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     *
     * @return mixed data
     */
    public function auth(Request $request)
    {
        if (!User::where('email', $request->get('email'))->first()) {
            return response()->json(['error' => 'account_does_not_exist'], 400);
        }
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = $this->auth->attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(['token' => compact('token')['token']]);
    }
}
