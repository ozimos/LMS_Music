<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Auth\Events\Registered;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Http\Controllers\Auth\RegisterController as WebRegisterController;
use Illuminate\Http\Response;

class RegisterController extends WebRegisterController
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([]);
    }
     /**
     * Handle a registration request for the application.
     *
     * @param  ApiFormRequest  $request
     * @return Response
     */
    public function apiRegister(ApiFormRequest $request)
    {
        $user = $this->create($request->all());
        event(app(Registered::class, ['user' => $user]));

        return $this->registered($request, $user);
    }

    /**
     * The user has been registered.
     *
     * @param Request $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 201) ;
    }
}
