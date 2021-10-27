<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request){

        $user = new User();
        $country = Country::where('country_name', $request->country)->first();
        $city = City::where('city_name', $request->city)->first();

        DB::beginTransaction();
        if($city){
            $user->city()->associate($city);
        }
        else{
            $newCity = new City();
            $newCity->city_name = $request->city;
            try{
                $newCity->save();
                $user->city()->associate($newCity);
            }
            catch (\PDOException $e){
                DB::rollBack();
                return redirect()->back()->with('error', 'Došlo je do greške prilikom registracije, molimo Vas pokušajte kasnije');
            }
        }
        if($country){
            $user->country()->associate($country);
        }
        else{
            $newCountry = new Country();
            $newCountry->country_name = $request->country;
            try{
                $newCountry->save();
                $user->country()->associate($newCountry);
            }
            catch (\PDOException $e){
                DB::rollBack();
                return redirect()->back()->with('error', 'Došlo je do greške prilikom registracije, molimo Vas pokušajte kasnije');
            }
        }
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
}
