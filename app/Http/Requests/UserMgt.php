<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserMgt extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required',
            'employer' => 'required',
            'dashboard' => 'required',
            'employees' => 'required',
            'employers' => 'required',
            'payout' => 'required',
            'job' => 'required',
            'reports' => 'required',
            'push' => 'required',
            'recipient' => 'required',
            'settings' => 'required',
            'password' => 'required|min:8'
        ];
    }
}
