@extends('layouts.layout')

@section('title')
    {{ $invoice->invoice_name }} | {{ $invoice->client->client_name }} | Izmeni Fakturu
@endsection


@section('content')
    <div class="row w-100 d-flex justify-content-around align-items-center bg-light py-3">
        <div class="col-2 fw-bold">Faktura {{ $invoice->invoice_name }}</div>
        <div class="col-2">
            <form action="#">
                <button type="submit" class="btn btn-primary"><i class="fas fa-check me-2 text-white"></i>Sačuvaj</button>
            </form>
        </div>
    </div>
    <div class="row w-100">
        <div class="container-fluid">
            <div class="container d-flex pt-5">
                <div class="col-md-6">
                    <h1 class="fs-3 text-primary">{{ $invoice->client->client_name }}</h1>
                    <p class="mt-3 mb-0">{{ $invoice->client->address }}</p>
                    <p class="mt-1 mb-0">{{ $invoice->client->city->name }} {{ $invoice->client->zip }}</p>
                    <p class="mt-1">{{ $invoice->client->country->name }}</p>
                    <p><span class="fw-bold">Email: </span><a class="text-dark text-decoration-none" href="mailto:{{ $invoice->client->email }}">{{ $invoice->client->email }}</a></p>
                </div>
                <div class="col-md-5 ms-auto d-flex py-2 flex-column justify-content-center border rounded ">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-center mb-1">
                            <div class="col-md-5 d-flex align-items-center justify-content-end"><p class="mb-0">Faktura#</p></div>
                            <div class=" container col-md-7">
                                <input class="form-control" value="{{ $invoice->invoice_name }}" type="text"/>
                            </div>
                        </li>
                        <li class="d-flex mb-1">
                            <div class="col-md-5 d-flex align-items-center justify-content-end">Datum izdavanja</div>
                            <div class="container col-md-7">
                                <input type="date" value="{{ $invoice->date_created }}" class="form-control"/>
                            </div>
                        </li>
                        <li class="d-flex mb-1">
                            <div class="col-md-5 d-flex align-items-center justify-content-end">Datum prometa</div>
                            <div class="container col-md-7">
                                <input type="date" value="{{ $invoice->date_of_traffic }}" class="form-control"/>
                            </div>
                        </li>
                        <li class="d-flex mb-1">
                            <div class="col-md-5 d-flex align-items-center justify-content-end">Valuta</div>
                            <div class="container col-md-7">
                                <input type="date" value="{{ $invoice->end_date }}" class="form-control"/>
                            </div>
                        </li>
                        <li class="d-flex">
                            <div class="col-md-5 d-flex align-items-center justify-content-end">Status</div>
                            <div class="container col-md-7">
                                <select name="status" class="form-select">
                                    @foreach($invoiceStatuses as $status)
                                        <option @if($invoice->invoiceStatus->id == $status->id) selected="selected" @endif value="{{ $status->id }}">{{ $status->status_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @if(session()->has('success'))
        <x-alert type="success" message="{{session()->get('success')}}" />
    @endif
@endsection
