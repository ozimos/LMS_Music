<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\OneUppercase;
use App\Rules\OneLowercase;
use App\Rules\OneInteger;
use App\Rules\OneSpecialCharacter;

class UserRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

     /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 
                            new OneInteger, new OneLowercase, 
                            new OneUppercase, new OneSpecialCharacter],
            'isArtiste' => ['boolean', 'sometimes'],
        ];
    }

    public function messages()
    {
        return [
            "password.regex" => "Adapter Name is required!",
            
        ];
    }
}
