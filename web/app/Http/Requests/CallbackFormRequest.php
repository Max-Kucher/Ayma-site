<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CallbackFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|in:order_chatbot,partnership',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[\d\s\(\)-]+$/|max:20',
            'email' => 'required|string|email|max:255',
            'telegram' => 'nullable|string|starts_with:@|max:50',
            'comment' => 'nullable|string|max:1000',
        ];
    }
}
