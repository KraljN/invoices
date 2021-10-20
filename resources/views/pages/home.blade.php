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
        <form class="row g-3 ">
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Korisnicko Ime</label>
                <input type="text" class="form-control" id="inputEmail4">
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Lozinka</label>
                <input type="password" class="form-control" id="inputPassword4">
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" class="form-control" id="inputEmail4">
            </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Matični Broj Firme</label>
                <input type="text" class="form-control" id="inputEmail4">
            </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">PIB</label>
                <input type="text" class="form-control" id="inputEmail4">
            </div>
            <div class="col-12">
                <label for="inputEmail4" class="form-label">Pun Naziv Firme Sa Rešenja</label>
                <input type="text" class="form-control" id="inputEmail4">
            </div>
            <div class="row mt-2">
                <label class="form-label">Žiro Račun</label>
                <div class="d-flex align-items-center">
                    <div class="col-4 me-1">
                        <input type="text" class="form-control" id="inputEmail4">
                    </div>
                    <span>-</span>
                    <div class="col-6 mx-1">
                        <input type="text" class="form-control" id="inputEmail4">
                    </div>
                    <span>-</span>
                    <div class="col-2 ms-1">
                        <input type="text" class="form-control" id="inputEmail4">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Adresa</label>
                <input type="text" class="form-control" id="inputAddress">
            </div>
            <div class="col-md-6">
                <label for="inputCity" class="form-label">Grad</label>
                <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="col-md-4">
                <label for="inputZip" class="form-label">Država</label>
                <input type="text" class="form-control" id="inputZip">
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label">Poštanski broj</label>
                <input type="text" class="form-control" id="inputZip">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-dark">Registruj se</button>
            </div>
        </form>
    </div>

@endsection
