<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'full_company_name'=>'Pun naziv firme',
            'email'=>'Email',
            'bank_number'=>'Žiro račun',
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
            'password'=>'regex:/[\dA-z\.\-\_]{4,15}/',
            'username'=>'regex:/[\dA-z\.\-\_]{4,15}/',
            'registration_number'=>'required|digits:8',
            'zip'=>'required|digits:5',
            'vat'=>'required|alpha_num|max:20',
            'full_company_name'=>'required|max:100',
            'bank_number'=>'required|digits:18',
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
            'bank_number.digits' => 'Morate uneti tačno 18 cifara.',
            'password.regex'=>'Dozvoljeni brojevi, slova i .-_ (4-15 karaktera)',
            'country.regex'=>'Dozvoljena samo slova (Crna Gora)',
            'city.regex'=>'Dozvoljena samo slova (Novi Sad)',
            'address.regex'=>'Netačan format adrese (Takovska 17)',
            'username.regex'=>'Dozvoljeni brojevi, slova i .-_ (4-15 karaktera)',
            'vat.alpha_num'=>'Dozvoljeni su samo brojevi i slova(za inostrane firme)',
            'max'=>':attribute ne sme sadržati više od :max karaktera',
            'required'=>':attribute polje je obavezno.',
        ];
    }

}
