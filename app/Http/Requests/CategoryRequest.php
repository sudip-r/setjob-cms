<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        if ($this->method() == 'POST') {
            return [
                'category' => 'required|max:255',
                'slug' => 'required | unique:categories,slug',
                'parent' => 'required',
            ];
        } else {
            return [
                'category' => 'required|max:255',
                'slug' => 'required | unique:categories,slug,' . $this->id
            ];
        }

    }
}
