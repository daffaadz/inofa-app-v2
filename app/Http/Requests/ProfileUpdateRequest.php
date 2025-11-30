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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id)
            ],
            'location' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:500'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'rate_min' => ['nullable', 'numeric', 'min:0'],
            'rate_max' => ['nullable', 'numeric', 'min:0', 'gte:rate_min'],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:50'],
            'experience' => ['nullable', 'string'],
        ];
    }
}
