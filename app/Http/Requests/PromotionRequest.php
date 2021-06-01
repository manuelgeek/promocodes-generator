<?php

namespace App\Http\Requests;

use App\Models\Promotion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PromotionRequest extends FormRequest
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
            'title' => 'required|string:max:255',
            'event_name' => 'required|string:max:255',
            'description' => 'required|string:max:1000',
            'no_of_tickets' => 'required|integer',
            'amount' => 'required|integer',
            'event_location' => 'required|string:max:100',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer',
            'expiry_date' => 'sometimes|date_format:d-m-Y H:i:s',
            'status' => ['required', Rule::in([Promotion::ACTIVE, Promotion::INACTIVE]),],
        ];
    }
}
