<?php

namespace Modules\Discount\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => ['required', 'string', 'min:5', 'max:10', Rule::unique('discounts', 'code')->ignore($this->code, 'code')],
            'percent' => ['required', 'integer', 'between:1,99'],
            'expired_at' => ['required'],
            'users' => ['nullable', 'array', 'exists:users,id'],
            'products' => ['nullable', 'array', 'exists:products,id'],
            'categories' => ['nullable', 'array', 'exists:categories,id'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
