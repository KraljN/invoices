@extends('layouts.layout')

@section('title')
    Početna
@endsection

@section('content')
    <div class="container my-3 py-2 border rounded">
        <h2 class="fs-3 fw-normal">Prijavite se na naš sistem</h2>
        <form class="row g-3 ">
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Korisničko Ime</label>
                <input type="email" class="form-control" id="inputEmail4">
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Lozinka</label>
                <input type="password" class="form-control" id="inputPassword4">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-dark">Prijavi se</button>
            </div>
        </form>
    </div>

    <div class="container mt-3 py-2 border rounded">
        <h2 class="fs-3 fw-normal">Registrujte se ako nemate nalog</h2>
        <form class="row g-3" method="post" action="{{route('user_register')}}">
            @csrf
            <div class="col-md-6">
                <label class="form-label">Korisnicko Ime</label>
                <input type="text" value="{{old('username')}}" class="form-control" name="username">
                @error('username')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Lozinka</label>
                <input type="password" value="{{old('password')}}" class="form-control" name="password">
                @error('password')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label class="form-label">Email</label>
                <input type="email" value="{{old('email')}}" class="form-control" name="email">
                @error('email')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Matični Broj Firme</label>
                <input type="text" value="{{old('registration_number')}}" class="form-control" name="registration_number">
                @error('registration_number')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">PIB</label>
                <input type="text" value="{{old('vat')}}" class="form-control" name="vat">
                @error('vat')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label class="form-label">Pun Naziv Firme Sa Rešenja</label>
                <input type="text" value="{{old('full_company_name')}}" class="form-control" name="full_company_name">
                @error('full_company_name')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label class="form-label">Žiro Račun</label>
                <input type="text" value="{{old('bank_number')}}" class="form-control" name="bank_number">
                @error('bank_number')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label class="form-label">Adresa</label>
                <input type="text" value="{{old('address')}}" class="form-control" name="address">
                @error('address')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Grad</label>
                <input type="text" value="{{old('city')}}" class="form-control" name="city">
                @error('city')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Država</label>
                <input type="text" value="{{old('country')}}" class="form-control" name="country">
                @error('country')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-2">
                <label class="form-label">Poštanski broj</label>
                <input type="text" value="{{old('zip')}}" class="form-control" name="zip">
                @error('zip')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
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

@endsection
