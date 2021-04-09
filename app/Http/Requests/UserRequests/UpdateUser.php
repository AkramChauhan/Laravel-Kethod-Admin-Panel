<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            'name' => 'required',
            'email' =>  "unique:users,email,$this->id,id",
            'old_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|required_with:old_password',
            'password_confirmation' => 'same:password',
        ];
    }
}
