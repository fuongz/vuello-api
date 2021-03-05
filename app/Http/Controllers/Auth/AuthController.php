<?php

namespace App\Http\Controllers\Auth;

// Exceptions
use Exception;
use Illuminate\Validation\ValidationException;

// Vendors
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// In app
use App\Repositories\Auth\AuthRepositoryInterface;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    private $request;
    private $authRepository;

    /**
     * AuthController constructor.
     * @param Request $request
     * @param AuthRepositoryInterface $authRepository
     */
    public function __construct(Request $request, AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
        $this->request = $request;
    }


    /**
     * @param int|null $id
     * @return JsonResponse|mixed
     */
    public function get($id = null) {
        try {
            if (is_null($id)) {
                $data = $this->authRepository->getMe();
            } else {
                $data = $this->authRepository->getUser($id);
            }
            return $this->responseSuccess($data);
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }


    /**
     * Authenticate
     *
     * @return JsonResponse
     */
    public function login()
    {
        try {
            // Validate input
            $this->validate($this->request, [
                'email' => ['required', 'email'],
                'password' => ['required']
            ]);

            // Try to authenticate with a credential
            $auth = $this->authRepository->auth($this->request);
            return $this->respondWithToken($auth['token'], $auth['user']);
        } catch (ValidationException $e) {
            return $this->responseError($e->errors());
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }


    /**
     * Register
     *
     * @return JsonResponse
     */
    public function register()
    {
        try {
            // Validate input
            $this->validate($this->request, [
                'email' => ['required', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'username' => ['string'],
                'firstName' => ['string'],
                'lastName' => ['string'],
            ]);

            // Try to create a new user
            $auth = $this->authRepository->register($this->request);
            return $this->respondWithToken($auth['token'], $auth['user']);
        } catch (ValidationException $e) {
            return $this->responseError($e->errors());
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }
}
