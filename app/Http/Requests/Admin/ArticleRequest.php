<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        if ($this->isMethod('POST')) {
            return Auth::check();
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $article = $this->route('article');
            if ($article) {
                return Gate::allows('update', $article);
            }
        }

        return false;
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'short_description' => ['required', 'string', 'max:255'],
            'text' => ['nullable', 'string'],
            'type' => ['required', 'string', 'in:blog,news'],
            'created_by' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'A title is required for the article.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title cannot be longer than 100 characters.',
            'short_description.required' => 'A short description is required for the article.',
            'short_description.string' => 'The short description must be a string.',
            'short_description.max' => 'The short description cannot be longer than 255 characters.',
            'type.required' => 'The article type is required.',
            'type.string' => 'The article type must be a string.',
            'type.in' => 'The article type must be either "blog" or "news".',
            'text.string' => 'The article content must be a string.',
            'created_by.required' => 'The creator ID is required.',
            'created_by.integer' => 'The creator ID must be an integer.',
            'created_by.exists' => 'The specified creator does not exist in our records.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'created_by' => Auth::user()->id,
        ]);
    }
}
