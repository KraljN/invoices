@extends('layouts.layout')

@section('title')
    Izmeni Fakturu
@endsection


@section('content')
    <div class="row w-100 d-flex justify-content-around align-items-center bg-light py-3">
        <div class="col-2 fw-bold">Faktura</div>
        <div class="col-2">
            <form action="#">
                <button type="submit" class="btn btn-primary"><i class="fas fa-plus me-2 text-white"></i> Izmeni Fakturu</button>
            </form>
        </div>
    </div>
    @if(session()->has('success'))
        <x-alert type="success" message="{{session()->get('success')}}" />
    @endif
@endsection
