<?php

namespace App\Repositories\Auth;

// Exceptions
use Exception;

// Vendors
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

// In app
use App\Repositories\BaseRepository;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthRepository
 * @package App\Repositories\Auth
 */
class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{

    /**
     * @return mixed|string
     */
    public function getModel()
    {
        return User::class;
    }


    /**
     * @return mixed
     */
    public function getMe() {
        $user = $this->model->find(Auth::id());

        return $user->release();
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function getUser($id) {
        $user = $this->model->query()->where('id', $id)->first();

        return $user->release();
    }


    /**
     * @param Request $request
     * @return mixed|void
     * @throws Exception
     */
    public function auth($request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            throw new Exception(__('Unauthorized'), 401);
        }

        return [
            'token' => $token,
            'user' => $request->user()
        ];
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function register(Request $request)
    {
        // Create a user payload
        $payload = [
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'username' => $request->input('username') ?? "",
            'full_name' => $request->input('firstName') . ' ' . $request->input('lastName') ?? "",
            'details' => json_encode([
                'phone_number' => $request->input('phoneNumber') ?? "",
                'address' => $request->input('address') ?? "",
            ])
        ];

        try {
            $auth = $this->create($payload);

            $credentials = $request->only(['email', 'password']);

            if (!$token = Auth::attempt($credentials)) {
                throw new Exception(__('Unauthorized'), 401);
            }

            return [
                'token' => $token,
                'user' => $auth
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function getUpdateAttributes($request){}
    public function getCreateAttributes($request){}
    public function onBeforeCreate(){}
    public function onAfterCreate(){}
    public function onBeforeUpdate(){}
    public function onAfterUpdate(){}
}