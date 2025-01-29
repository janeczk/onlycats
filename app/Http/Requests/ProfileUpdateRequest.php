<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        abort_if(!$this->user(), 500);
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
                ],
            'username' => [
                'nullable', // Może być puste (jeśli użytkownik tego nie edytuje)
                'string',
                'max:255',
                'unique:users,username,' . $this->user()->id, // Musi być unikalne
                'regex:/^@.+$/', // Wymaga znaku @ na początku
            ],
            'bio' => ['nullable', 'string', 'max:500'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
           // 'background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Walidacja dla obrazu tła
        ];
    }
}
