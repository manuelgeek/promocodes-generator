<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsePromoCodeRequest extends FormRequest
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
        return [
            'origin.latitude' => 'required|numeric',
            'origin.longitude' => 'required|numeric',
            'destination.latitude' => 'required|numeric',
            'destination.longitude' => 'required|numeric',
        ];
    }
}
