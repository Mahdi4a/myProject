<?php

namespace Modules\User\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class twoFactorRequest extends FormRequest
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
            'type' => "required|in:off,sms",
            'phone' => "required_unless:type,off|unique:users,phone_number," . auth()->user()->id,
        ];
    }
}
