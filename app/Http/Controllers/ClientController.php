<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ClientRegisterRequest;
use App\Models\City;
use App\Models\Client;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['clients'] = Client::with(['country', 'city', 'invoices', 'invoices.payments', 'invoices.items'])->where('user_id', Auth::user()->id)->get();
        foreach ($this->data['clients'] as $client){
            $client->debt = Helper::countDebt($client);
        }
        return view('pages.clients.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['client_info'] = new Client(); // Dodato da ne bi bacalo grešku u formi za insert: Undefined variable $client_info
        return view('pages.clients.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRegisterRequest $request)
    {
        $client = new Client();
        DB::beginTransaction();

        $client =  Helper::insertIfNameDoesntExist($request->country, new Country(), $client->country());
        $client = Helper::insertIfNameDoesntExist($request->city, new City(), $client->city());

        $client->user()->associate(Auth::user());
        $client->vat = $request->vat;
        $client->bank_account_number = $request->bank_number;
        $client->address = $request->address;
        $client->registration_number = $request->registration_number;
        $client->email = $request->email;
        $client->client_name = $request->full_company_name;
        $client->zip = $request->zip;


        try{
            $client->save();
            DB::commit();
            return  redirect()->back()->with('success', 'Uspešno je dodat novi klijent.');
        }
        catch (\PDOException $e){
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
//            Došlo je do greške prilikom dodavanja klijenta. Molimo pokušajte kasnije.

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['client_info'] = Client::with(['country', 'city'])->find($id);
        return view('pages.clients.form', $this->data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRegisterRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
