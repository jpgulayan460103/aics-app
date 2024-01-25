<?php

namespace App\Http\Requests;

use App\Rules\AllowedStringName;
use App\Rules\ValidCellphoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class AicsClientUpdateRequest extends FormRequest
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
            'aics_type_id' => ['required', 'exists:aics_types,id'],
            'last_name' => ['required', 'string', 'max:200', new AllowedStringName],
            'first_name' => ['required', 'string', 'max:200', new AllowedStringName],
            'psgc_id' => ['required', 'exists:psgcs,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'gender' => ['required'],
            'street_number' => ['max:200'],
            'civil_status' => ['required'],
            'birth_date' => ['required', 'date'],
            'age' => ['required', 'numeric','min:18', 'max:120'],
            'mobile_number' => [new ValidCellphoneNumber]
        ];
    }
}
