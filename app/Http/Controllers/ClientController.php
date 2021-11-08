<?php

namespace App\Http\Controllers;


use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Repository\ClientRepositoryInterface;
use App\Repository\Eloquent\ClientRepository;
use Illuminate\Support\Facades\Auth;

class ClientController extends BaseController
{

    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $this->data['clients'] = Client::with(['country', 'city', 'invoices', 'invoices.payments', 'invoices.items'])->where('user_id', Auth::user()->id)->get();
        foreach ($this->data['clients'] as $client){
            $client->debt = $this->clientRepository->countDebt($client);
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
        $inserted = $this->clientRepository->create($request->except('_token'));

        if($inserted){
            return  redirect()->back()->with('success', 'Uspešno dodat klijent.');

        }
        return  redirect()->back()->with('error', 'Došlo je do greške prilikom dodavanja klijenta. Molimo Vas pokušajte kasnije.');


    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  CLient  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
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
     * @param  Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $client)
    {
               $updated = $this->clientRepository->update($client, $request->except('_token'));
               if($updated){
                   return  redirect()->back()->with('success', 'Uspešno izmenjen klijent.');

               }
               return  redirect()->back()->with('error', 'Došlo je do greške prilikom izmene klijenta. Molimo Vas pokušajte kasnije.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->clientRepository->deleteById($id);
        return back();
    }
}
