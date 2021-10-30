<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function register(UserRegisterRequest $request){

        $user = new User();
        DB::beginTransaction();

        Helper::insertIfNameDoesntExist($request->country, new Country(), $user);
        Helper::insertIfNameDoesntExist($request->city, new City(), $user);

        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->vat = $request->vat;
        $user->bank_account_number = $request->bank_number;
        $user->address = $request->address;
        $user->registration_number = $request->registration_number;
        $user->email = $request->email;
        $user->full_company_name = $request->full_company_name;
        $user->zip = $request->zip;
        $user->is_active = Config::get('constants.activity.active');

        try{
            $user->save();
            DB::commit();
            return  redirect()->back()->with('success', 'Uspešno je dodat novi korisnik');
        }
        catch (\PDOException $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Već postoji korisnik sa tim korisničkim imenom');

        }

    }

    public function login(LoginRequest $request){

        if (Auth::attempt(['username' => $request->login_username, 'password' => $request->login_password, 'is_active' => 1])) {

            $request->session()->regenerate();
            return back();
        }
        else{
            return back()->with('loginError', 'Neispravna lozinka ili korisničko ime');
        }
    }
    public function logout(){

        Auth::logout();
        return redirect("/");

    }
}
