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
            'invoice_name'=>'Naziv Fakture',
            'date_created'=>'Datum Fakture',
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
            'client'=>"required|regex:/[^0]/",
            'invoice_name'=>"required",
            'date_created'=>"required|date"
        ];
    }
    public function messages()
    {
        return [
            'client.min'=>'Morate odabrati klijenta',
            'client.regex'=>'Morate odabrati klijenta',
            'required'=>':attribute polje je obavezno.',
            'date_created.date'=>'Datum Fakture'
        ];
    }
}
