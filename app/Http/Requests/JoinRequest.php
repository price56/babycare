<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JoinRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'name' => ['required', 'string'],
            'mobile' => ['required'],
            'password' => 'required|min:8|max:32|regex:/^(?=.*[a-zA-Z])(?=.*[0-9]).{8,32}$/',
        ];
    }

    public function joinUserData(): array
    {
        return $this->only(['email', 'mobile', 'name', 'password']);
    }
}
