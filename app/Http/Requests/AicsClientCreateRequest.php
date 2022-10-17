<?php

namespace App\Http\Requests;

use App\Rules\ValidCellphoneNumber;
use App\Rules\ValidNameString;
use App\Rules\ValidString;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class AicsClientCreateRequest extends FormRequest
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
            'last_name' => ['required', 'string', 'max:100', new ValidNameString],
            'first_name' => ['required', 'string', 'max:100', new ValidNameString],
            'middle_name' => ['required', 'string', 'max:100', new ValidNameString],
            'ext_name' => ['nullable', 'string', 'max:3', new ValidNameString],
            'street_number' => ['required', 'string', 'max:100', new ValidString],
            'psgc_id' => ['required'],
            'mobile_number' => ['required', 'string', new ValidCellphoneNumber],
            'birth_date' => ['required', 'date' , 'before_or_equal:'.Carbon::now()->toDateString()],
            'rel_beneficiary' => ['required', 'string', 'max:100', new ValidString],
        ];
    }
}
