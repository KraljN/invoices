<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ClientRequest;
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
    public function store(ClientRequest $request)
    {
        $client = new Client();
        return Helper::fillClientValues($request, $client, 'Uspešno dodat novi klijent.');

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
        $client = Client::with(['country', 'city'])->find($id);
        //Ovo radimo da bi u form.blade.php prikazali sa $client->country umesto $client->country->name jer ce kod store funkcije $client->country biti null pa se nece moci procitati name iz null
        $client->country = $client->country->name;
        $client->city = $client->city->name;
        //=========================================
        $this->data['client_info'] = $client;
        return view('pages.clients.form', $this->data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, $id)
    {
        //Provera da li je neki podatak promenjen u odnosu na ono sto se nalazi u bazi
        $clientInDatabase = Client::with(['country', 'city'])->find($id);
        $optimizedClientToCompare = clone $clientInDatabase;
        //=======Prilagodjavanje atributa radi lakseg kasnijeg poredjenja===========
        $optimizedClientToCompare->country = $clientInDatabase->country->name;
        $optimizedClientToCompare->city = $clientInDatabase->city->name;
        //==========================================================================
        $dataFromClientInDatabase = $optimizedClientToCompare->attributesToArray();
        $formData = Helper::removeFromAssociativeArray($request->all(), ['_token', '_method']);
        $dataFromClientInDatabase = Helper::removeFromAssociativeArray($dataFromClientInDatabase, ['id', 'country_id', 'city_id', 'user_id', 'created_at', 'updated_at']);
        $difference = array_diff_assoc($formData, $dataFromClientInDatabase);
        //Kraj provere
        if( count( $difference ) == 0 ){
            return redirect()->back()->withInput()->with('error', 'Morate promeniti makar jedno polje.');
        }
        else{
            return Helper::fillClientValues($request, $clientInDatabase, 'Uspešno izmenjen klijent.');
        }
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
