<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceCreateRequest extends FormRequest
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

    public function attributes()
    {
        return [
            'client'=>'Klijent',
            'name'=>'Naziv Fakture',
            'date'=>'Datum Fakture',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client'=>"required|min:1",
            'name'=>"required",
            'date'=>"required|date"
        ];
    }
    public function messages()
    {
        return [
            'client.min'=>'Morate odabrati klijenta',
            'required'=>':attribute polje je obavezno.',
            'date.date'=>'Datum Fakture'
        ];
    }
}
