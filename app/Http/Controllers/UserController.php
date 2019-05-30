<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\UserResource;
use App\Contracts\Repositories\UserRepository;

class UserController extends Controller
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

    public function index()
    { 
        return UserResource::collection($this->userRepository->all());
    }

    public function show(Request $request, $id)
    {
        return new UserResource($this->userRepository->find($id));
    }
}
