<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'registration_number'=>'Matični broj firme',
            'vat'=>'PIB',
            'client_name'=>'Naziv Klijenta',
            'email'=>'Email',
            'bank_account_number'=>'Žiro račun',
            'country'=>'Država',
            'city'=>'Grad',
            'zip'=>'Poštanski broj',
            'address'=>'Adresa'
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
            'email'=>'required|email|min:10',
            'registration_number'=>'required|digits:8',
            'zip'=>'required|digits:5',
            'vat'=>'required|max:20|regex:/^([A-Z]{2})?[0-9]{3,15}$/',
            'client_name'=>'required|max:100',
            'bank_account_number'=>'required|digits:18',
            'country'=>'required|max:50|regex:/[A-ZĐŠĆŽČ][a-zšđćžč]{1,15}(\s[A-zšđćžčĐŠĆŽČ]{2,30})*/',
            'address'=>'required|max:50|regex:/^[A-Z][\w]{5,20}(\s[\w]{5,20}){0,5}(\s[0-9]{1,4}[a-z]?)$/',
            'city'=>'required|max:50|regex:/[A-ZĐŠĆŽČ][a-zšđćžč]{1,20}(\s[A-zšđćžčĐŠĆŽČ]{2,30})*/',
        ];
    }

    public function messages()
    {
        return [
            'email.email'=>'Unesite email u željenom formatu (petar@gmail.com)',
            'registration_number.digits' => 'Morate uneti tačno 8 cifara.',
            'zip.digits' => 'Morate uneti tačno 5 cifara.',
            'bank_account_number.digits' => 'Morate uneti tačno 18 cifara.',
            'country.regex'=>'Dozvoljena samo slova (Crna Gora)',
            'city.regex'=>'Dozvoljena samo slova (Novi Sad)',
            'address.regex'=>'Netačan format adrese (Takovska 17)',
            'vat.regex'=>'Netačan format FR1234578 (Inostranstvo) / 123456789 (Srbija)',
            'max'=>':attribute ne sme sadržati više od :max karaktera',
            'required'=>':attribute polje je obavezno.',
        ];
    }
}
