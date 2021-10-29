<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppealPostRequest extends FormRequest
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
            'name' => 'required|string|max:20',
            'surname' => 'required|string|max:40',
            'patronymic' => 'nullable|string|max:20',
            'age' => 'required|integer|between:14,122',
            'gender' => ['required', Rule::in([Gender::MALE, Gender::FEMALE])],
            'email' => 'nullable|required_without:phone|regex:/^[^@]+@[^@.]+\.[^@.]+$/|string|max:100',
            'phone' => 'nullable|required_without:email|starts_with:+7,7,8||regex:/^\+?\d\s?\([0-9]{3}\)(\s?\-?[0-9]){7}$/|string|max:20',
            'message' => 'required|string|max:100',
        ];
    }
}
