<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
        if($this->method() == 'POST')
            return [
                'title' => 'required|max:255',
                'summary' => 'required',
                'user_id' => 'required|not_in:0'
            ];
        else
            return [
                'title' => 'required|max:255',
                'summary' => 'required',
                'user_id' => 'required|not_in:0'
            ];

    }

    /**
     * Custom Request Message
     * 
     * @return Array
     */
    public function messages()
    {
        return [
            'title.required' => 'Job title is required',
            'summary.required' => 'Job summary is required. Enter short description of the job.',
            'user_id.not_in' => 'Select a company for which you are posting the job'
        ];
    }
}
