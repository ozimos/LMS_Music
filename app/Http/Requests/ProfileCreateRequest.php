<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileCreateRequest extends FormRequest
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
            'content' => ['required', 'string'],
            'twitter' => ['sometimes', 'required', 'string', 'min:8', 'confirmed'],
            'website' => ['sometimes', 'required', 'string', 'url', 'max:255'],
            'twitter' => ['boolean', 'sometimes', 'string', 'max:255', 'regex:/^(\@)?([a-z0-9_]{1,15})$/i'],
            'facebook' => ['boolean', 'sometimes', 'string', 'max:255', 'regex:/^[a-z\d.]{5,}$/i'],
            'instagram' => ['boolean', 'sometimes', 'string', 'max:255', 'regex:/^[a-zA-Z0-9._]+$/i'],
        ];
    }
}
