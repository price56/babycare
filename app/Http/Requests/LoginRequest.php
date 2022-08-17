<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required_without:mobile|email',
            'mobile' => 'string',
            'password' => 'required',
        ];
    }

    private function mobile(): null|string
    {
        return $this->get('mobile');
    }

    private function email(): null|string
    {
        return $this->get('email');
    }

    public function password(): string
    {
        return $this->get('password');
    }

    public function authId(): array
    {
        $data = [];

        if ($email = $this->email()) {
            $data['email'] = $email;
        }

        if ($mobile = $this->mobile()) {
            $data['mobile'] = $mobile;
        }

        return $data;
    }

}
