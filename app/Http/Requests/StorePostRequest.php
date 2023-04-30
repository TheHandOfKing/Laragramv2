<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'string|required',
            'location' => 'string|required',
            'no_comments' => 'boolean|required',
            'likes_view' => 'boolean|required',
            'user_id' => 'integer|exists:users,id|required'
        ];
    }
}
