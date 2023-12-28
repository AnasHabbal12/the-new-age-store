<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->route('category')) {
            return Gate::allows('categories.update');
        }
        Gate::allows('categories.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->route('category');
        return [
            'name' => ['required', 'string', 'min:3', 'max:254', "unique:categories,name,$id"],
            'parent_id' => ['nullable', 'int', 'exists:categories,id'],
            'img' => ['image', 'max:2148999', 'dimensions:min_width=100,min_height:100'],
            'status' => 'required|in:active,archived'
        ];
    }

    public function messages() {
        return [
            'required' => 'this is nacessary field!',
            'inique' => 'this name is already exists!',
            'min:3' => 'you entered less than 3 charachter'
        ];
    }
}
