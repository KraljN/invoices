@extends('layouts.layout')

@section('title')
    Početna
@endsection

@section('content')
    @guest
        <div class="container my-3 py-2 border rounded">
            <h2 class="fs-3 fw-normal">Prijavite se na naš sistem</h2>
            <form class="row g-3 " method="POST" action="{{route('login')}}">
                @csrf
                <div class="col-md-6">
                    <label class="form-label">Korisničko Ime</label>
                    <input type="text" name="login_username" class="form-control"/>
                    @error('login_username')
                        <x-alert type="danger" :message="$message" />
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Lozinka</label>
                    <input type="password" name="login_password" class="form-control"/>
                    @error('login_username')
                        <x-alert type="danger" :message="$message" />
                    @enderror
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-dark">Prijavi se</button>
                </div>
                @if(session()->has('loginError'))
                    <x-alert type="danger" message="{{session()->get('loginError')}}" />
                @endif
            </form>
        </div>

        <div class="container mt-3 py-2 border rounded">
            <h2 class="fs-3 fw-normal">Registrujte se ako nemate nalog</h2>
            <form class="row g-3" method="post" action="{{route('user_register')}}">
                @csrf
                <div class="col-md-6">
                    <label class="form-label">Korisnicko Ime</label>
                    <input type="text" value="{{old('username')}}" class="form-control" name="username"/>
                    @error('username')
                        <x-alert type="danger" :message="$message" />
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Lozinka</label>
                    <input type="password" value="{{old('password')}}" class="form-control" name="password"/>
                    @error('password')
                        <x-alert type="danger" :message="$message" />
                    @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Email</label>
                    <input type="email" value="{{old('email')}}" class="form-control" name="email"/>
                    @error('email')
                        <x-alert type="danger" :message="$message" />
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Matični Broj Firme</label>
                    <input type="text" value="{{old('registration_number')}}" class="form-control" name="registration_number"/>
                    @error('registration_number')
                        <x-alert type="danger" :message="$message" />
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">PIB</label>
                    <input type="text" value="{{old('vat')}}" class="form-control" name="vat"/>
                    @error('vat')
                        <x-alert type="danger" :message="$message" />
                    @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Pun Naziv Firme Sa Rešenja</label>
                    <input type="text" value="{{old('full_company_name')}}" class="form-control" name="full_company_name"/>
                    @error('full_company_name')
                        <x-alert type="danger" :message="$message" />
                    @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Žiro Račun</label>
                    <input type="text" value="{{old('bank_number')}}" class="form-control" name="bank_number"/>
                    @error('bank_number')
                        <x-alert type="danger" :message="$message" />
                    @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Adresa</label>
                    <input type="text" value="{{old('address')}}" class="form-control" name="address"/>
                    @error('address')
                        <x-alert type="danger" :message="$message" />
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Grad</label>
                    <input type="text" value="{{old('city')}}" class="form-control" name="city"/>
                    @error('city')
                        <x-alert type="danger" :message="$message" />
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Država</label>
                    <input type="text" value="{{old('country')}}" class="form-control" name="country"/>
                    @error('country')
                        <x-alert type="danger" :message="$message" />
                    @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label">Poštanski broj</label>
                    <input type="text" value="{{old('zip')}}" class="form-control" name="zip"/>
                    @error('zip')
                        <x-alert type="danger" :message="$message" />
                    @enderror
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-dark">Registruj se</button>
                </div>
                @if(session()->has('error'))
                    <x-alert type="danger" message="{{session()->get('error')}}" />
                @endif

                @if(session()->has('success'))
                    <x-alert type="success" message="{{session()->get('success')}}" />
                @endif
            </form>
        </div>
    @endguest

    @auth
        <div class="container-fluid m-0  bg-light py-3">
            <div class="container d-flex flex-column flex-md-row justify-content-around align-items-center">
                <div class="col-2 fw-bold">Fakture</div>
                <div class="col-md-8">
                    <form class="d-flex flex-column flex-md-row" action="{{ route('home') }}" method="GET">
                        <div class="col-md-3">
                            <label class="visually-hidden" for="inlineFormInputGroupUsername">Ime Klijenta</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="fas fa-search"></i></div>
                                <input type="search" @if(request()->query->has('name'))  value="{{ request()->query('name') }}" @endif name="name" class="form-control" placeholder="Ime Klijenta"/>
                            </div>
                        </div>
                        <div class="col-md-3 ms-1">
                            <input class="form-control" @if(request()->query->has('date'))  value="{{ request()->query('date') }}" @endif name="date" type="date"/>
                        </div>
                        <div class="col-md-3 ms-1">
                            <select name="status" class="form-select">
                                <option value="0">Sve</option>
                                @foreach($invoiceStatuses as $status)
                                    <option @if(request()->query('status') == $status->id) selected="selected" @endif value="{{ $status->id }}">{{ $status->status_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1 ms-1">
                            <button class="btn btn-dark" type="submit">Pretraži</button>
                        </div>
                        <div class="col-md-2 ms-3">
                            <a class="btn btn-success" href="{{ route('home') }}">Prikaži Sve</a>
                        </div>
                    </form>
                </div>
                <div class="col-2">
                    <form action="{{ route('clients.create') }}">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus me-2 text-white"></i> Dodaj Fakturu</button>
                    </form>
                </div>
            </div>
        </div>
        <hr class="my-0"/>
        <div class="container">
            <div class="row w-100">
                @if( count( $invoices ) == 0)
                    <x-alert type="info" message="Nijedna faktura ne odgovara pretrazi. Molimo ubacite novu fakturu ako nema nijedne." />
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Status</th>
                                <th scope="col">Faktura</th>
                                <th scope="col">Datum Izdavanja</th>
                                <th scope="col">Valuta</th>
                                <th scope="col">Klijent</th>
                                <th scope="col">Ukupna Cena</th>
                                <th scope="col">Ukupno za plaćanje</th>
                                <th scope="col" class="text-center">Opcije</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td class="fw-bold" >{{ $invoice->invoiceStatus->status_name }}</td>
                                    <td>{{ $invoice->invoice_name }}</td>
                                    <td>{{ Helper::formatDate($invoice->date_created) }}</td>
                                    <td>{{ Helper::formatDate($invoice->end_date) }}</td>
                                    <td class="text-primary fw-bold">{{ $invoice->client->client_name }}</td>
                                    <td>{{ $invoice->total }} RSD</td>
                                    <td>{{ $invoice->debt }} RSD</td>
                                    <td class="d-flex justify-content-around align-items-center">
                                        <a href="{{ route('invoices.edit', $invoice->id) }}">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-edit text-white"></i>
                                            </button>
                                        </a>
                                        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash text-white"></i>
                                            </button>
                                        </form>

                                        <form action="#" method="POST">

                                            <button type="submit" class="btn btn-primary">
                                                <i class="far fa-envelope text-white"></i>
                                            </button>
                                        </form>

                                        <form action="#" method="POST">

                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-file-pdf text-white"></i>
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
    @endauth

@endsection
