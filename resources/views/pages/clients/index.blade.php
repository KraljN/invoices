@extends('layouts.layout')

@section('title')
    Klijenti
@endsection

@section('content')
    <div class="row w-100 d-flex justify-content-around align-items-center bg-light py-3">
        <div class="col-2 fw-bold">Klijenti</div>
        <div class="col-2">
            <form action="{{ route('clients.create') }}">
                <button type="submit" class="btn btn-primary"><i class="fas fa-plus me-2 text-white"></i> Dodaj Klijenta</button>
            </form>
        </div>
    </div>
    <hr class="my-0"/>
    <div class="container">
        <div class="row w-100">
            @if( count( $clients ) == 0)
                <x-alert type="info" message="Trenutno nemate ni jednog klijenta." />
            @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Naziv</th>
                        <th scope="col">Adresa</th>
                        <th scope="col">Grad</th>
                        <th scope="col">Poštanski Broj</th>
                        <th scope="col">Država</th>
                        <th scope="col">Ukupno za plaćanje</th>
                        <th scope="col" class="text-center">Opcije</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td class="text-primary fw-bold">{{ $client->client_name }}</td>
                            <td>{{ $client->address }}</td>
                            <td>{{ $client->city->city_name }}</td>
                            <td>{{ $client->zip }}</td>
                            <td>{{ $client->country->country_name }}</td>
                            <td>{{ $client->debt }} RSD</td>
                            <td class="d-flex justify-content-around align-items-center">
                                <form action="#">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-edit text-white"></i>
                                    </button>
                                </form>
                                <form action="#">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash text-white"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
@endsection
