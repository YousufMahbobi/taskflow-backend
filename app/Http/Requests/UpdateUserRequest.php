<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var User $user */
        $user = $this->route('user');

        return [
            'name'      => ['sometimes', 'string', 'max:255'],
            'email'     => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'password'  => ['sometimes', 'nullable', 'string', 'min:8'],
            'job_title' => ['sometimes', 'string', 'max:255'],
            'avatar'    => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1048'],
            'status'    => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Normalize incoming data.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('status')) {
            $this->merge([
                'status' => filter_var($this->status, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}
