<?php

namespace App\Repositories\Auth;

use Illuminate\Http\Request;

/**
 * Interface AuthRepositoryInterface
 * @package App\Repositories\Auth
 */
interface AuthRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function auth(Request $request);


    /**
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request);
}