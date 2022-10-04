<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'total' => 'required|numeric',
            'daily_budget' => 'required|numeric',
            'date' => 'required',
            'images.*' => 'mimes:jpeg,bmp,png',
        ];
    }

    public function messages()
    {
        return [
            'name' => 'name is required',
            "date" => "date is required",
            "total.required" => "total is required",
            "total.numeric" => "total must be a number",
            "daily_budget.required" => "daily budget is required",
            "daily_budget.numeric" => "daily budget must be a number"
        ];
    }
}
