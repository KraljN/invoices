@extends('layouts.layout')

@section('title')
    @if( request()->routeIs('clients.create') )
        Dodajte Novog Klijenta
    @else
        Izmenite Klijenta
    @endif
@endsection


@section('content')
    <div class="container mt-3 py-2 border rounded">
        <h2 class="fs-3 fw-normal">
            @if( request()->routeIs('clients.create') )
                Dodajte novog klijenta
            @else
                Izmenite informacije o klijentu
            @endif
        </h2>
        <form class="row g-3" method="post"
              action="
                    @if( request()->routeIs('clients.create') )
                          {{ route('clients.store') }}
                    @else
                          {{ route('clients.update', $client_info->id) }}
                    @endif
                  "
        >
            @csrf
            @if( request()->routeIs('clients.edit') )
                @method('PUT')
            @endif
            <div class="col-12">
                <label class="form-label">Naziv Klijenta</label>
                <input type="text" value="{{ old('client_name', $client_info->client_name) }}" class="form-control" name="client_name"/>
                @error('client_name')
                <x-alert type="danger" :message="$message" />
                @enderror
            </div>
            <div class="col-12">
                <label class="form-label">Email</label>
                <input type="email" value="{{ old('email', $client_info->email) }}" class="form-control" name="email"/>
                @error('email')
                <x-alert type="danger" :message="$message" />
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Matični Broj Firme</label>
                <input type="text" value="{{ old('registration_number', $client_info->registration_number) }}" class="form-control" name="registration_number"/>
                @error('registration_number')
                <x-alert type="danger" :message="$message" />
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">PIB</label>
                <input type="text" value="{{ old('vat', $client_info->vat) }}" class="form-control" name="vat"/>
                @error('vat')
                <x-alert type="danger" :message="$message" />
                @enderror
            </div>
            <div class="col-12">
                <label class="form-label">Žiro Račun</label>
                <input type="text" value="{{ old('bank_account_number', $client_info->bank_account_number) }}" class="form-control" name="bank_account_number"/>
                @error('bank_account_number')
                <x-alert type="danger" :message="$message" />
                @enderror
            </div>
            <div class="col-12">
                <label class="form-label">Adresa</label>
                <input type="text" value="{{ old('address', $client_info->address) }}" class="form-control" name="address"/>
                @error('address')
                <x-alert type="danger" :message="$message" />
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Grad</label>
                <input type="text" value="{{ old('city', $client_info->city) }}" class="form-control" name="city"/>
                @error('city')
                <x-alert type="danger" :message="$message" />
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Država</label>
                <input type="text" value="{{ old('country', $client_info->country) }}" class="form-control" name="country"/>
                @error('country')
                <x-alert type="danger" :message="$message" />
                @enderror
            </div>
            <div class="col-md-2">
                <label class="form-label">Poštanski broj</label>
                <input type="text" value="{{ old('zip', $client_info->zip) }}" class="form-control" name="zip"/>
                @error('zip')
                <x-alert type="danger" :message="$message" />
                @enderror
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-dark">
                @if( request()->routeIs('clients.create') )
                    Dodaj Klijenta
                @else
                    Izmeni
                @endif
                </button>
            </div>
            @if(session()->has('error'))
                <x-alert type="danger" message="{{session()->get('error')}}" />
            @endif

            @if(session()->has('success'))
                <x-alert type="success" message="{{session()->get('success')}}" />
            @endif
        </form>
    </div>
@endsection
