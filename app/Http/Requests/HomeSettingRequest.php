<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeSettingRequest extends FormRequest
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
        switch ($this->method()){
            case "POST":
                return [
                    'title' => 'required',
                    'sub_title' => 'required',
                    'left_col_title' => 'required',
                    'left_col_summary' => 'required',
                    'left_col_btn' => 'required',
                    'right_col_title' => 'required',
                    'right_col_summary' => 'required',
                    'right_col_btn' => 'required'

                ];
                 break;
            case "PATCH" :
                return [
                    'title' => 'required',
                    'sub_title' => 'required',
                    'left_col_title' => 'required',
                    'left_col_summary' => 'required',
                    'left_col_btn' => 'required',
                    'right_col_title' => 'required',
                    'right_col_summary' => 'required',
                    'right_col_btn' => 'required'
                ];
                break;
            default:
                return [
                    'title' => 'required',
                    'sub_title' => 'required',
                    'left_col_title' => 'required',
                    'left_col_summary' => 'required',
                    'left_col_btn' => 'required',
                    'right_col_title' => 'required',
                    'right_col_summary' => 'required',
                    'right_col_btn' => 'required'
                ];
        }
    }
}
