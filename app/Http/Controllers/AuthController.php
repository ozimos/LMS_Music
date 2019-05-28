<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Contracts\Repositories\UserRepository;
use App\User;
use Illuminate\Support\Facades\Hash;

use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;


class AuthController extends Controller
{

    private $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRequest $request)
    {
        $data = $request->only([
            'name', 'email', 'isArtiste', 'isAdmin', 
        ]);
        $data['password'] = Hash::make($request->password);
        $user = $this->userRepository->create($data);

        if(!$token = auth()->fromUser($user)){
            return abort(401);
        };

        return (new UserResource($request->user()))
            ->additional(['meta' => ['token' => $token]])
            ->response()
            ->setStatusCode(201);;
    }

    public function login(Request $request)
    {
        if (!$token = auth()->attempt($request->only(['email', 'password']))) {
            return response()->json([
                'errors' => [
                    'email' => ["Sorry we couldn't sign you in with those details."]
                ]
            ], 422);
        }

        return (new UserResource($request->user()))
            ->additional([
                'meta' => [
                    'token' => $token
                ]
            ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Logged out Successfully']);
    }

    public function user(Request $request)
    {
        return new UserResource($request->user());
    }

    public function refresh()
    {
        if ($token = auth()->refresh()) {
            return ['meta' => ['token' => $token]];
        }

        return response()->json(['error' => 'refresh_token_error'], 401);
    }
}
