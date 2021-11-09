@extends('layouts.layout')

@section('title')
    {{ $invoice->invoice_name }} | {{ $invoice->client->client_name }} | Izmeni Fakturu
@endsection


@section('content')
    <div class="row w-100 m-0 bg-light py-3">
        <div class="container-fluid">
            <div class="container d-flex justify-content-around align-items-center">
                <div class="col-8 fw-bold">Faktura {{ $invoice->invoice_name }}</div>
                <div class="col-2  ps-0">
                    <form action="#">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check me-2 text-white"></i>Sačuvaj</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row w-100 m-0">
        <div class="container-fluid">
            <div class="container d-flex pt-5">
                @if(session()->has('success'))
                    <x-alert type="success" message="{{session()->get('success')}}" />
                @endif
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
    <div class="row w-100 me-0 mt-5">
        <div class="container-fluid">
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Opis</th>
                            <th scope="col">Količina</th>
                            <th scope="col">Količina Cena</th>
                            <th scope="col">PDV</th>
                            <th scope="col">Cena Bez PDV</th>
                            <th scope="col">PDV</th>
                            <th scope="col">Ukupno</th>
                            <th scope="col">Opcije</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoiceItems as $item)
                            <form action="{{ route('invoice-items.update', $item->id) }}" method="POST">
                                <tr>
                                    <td>
                                        <textarea class="form-control" name="description"cols="5" rows="2">{{ $item->description }}</textarea>
                                    </td>
                                    <td>
                                        <input class="form-control" value="{{ $item->quantity }}" min="0" type="number"/>
                                    </td>
                                    <td>
                                        <input class="form-control" value="{{ $item->price }}" type="text"/>
                                    </td>
                                    <td>
                                        <select name="status" class="form-select">
                                            @foreach($pdvTypes as $pdv)
                                                @if( $pdv->pdv_type_name == 0)
                                                    <option value="0">
                                                        None
                                                    </option>
                                                @else
                                                    <option @if($item->pdvType->pdv_type_name == $pdv->pdv_type_name) selected="selected" @endif value="{{ $pdv->pdv_type_name }}">
                                                        {{ $pdv->pdv_type_name }}%
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        {{ ($item->quantity * $item->price) - ($item->quantity * $item->price)  *  $item->pdvType->pdv_type_name / 100 }} RSD
                                    </td>
                                    <td>
                                        {{ $item->pdvType->pdv_type_name / 100 }} RSD
                                    </td>
                                    <td>
                                        {{ ($item->quantity * $item->price) }} RSD
                                    </td>
                                    <td class="d-flex justify-content-around align-items-center">
                                        <a href="#">
                                            <button type="submit" class="btn btn-warning me-1">
                                                <i class="fas fa-edit text-white"></i>
                                            </button>
                                        </a>
                                        <form action="#" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash text-white"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            </form>
                        @endforeach
                        <form action="#" method="POST" id="insertInvoiceItem">
                        <tr>
                            <td>
                                <textarea class="form-control" name="description"cols="40" rows="2"></textarea>
                            </td>
                            <td>
                                <input class="form-control" min="0" type="number"/>
                            </td>
                            <td>
                                <input class="form-control" type="text"/>
                            </td>
                            <td>
                                <select name="status" class="form-select">
                                    @foreach($pdvTypes as $pdv)
                                            @if( $pdv->pdv_type_name == 0)
                                            <option value="0">
                                                None
                                            </option>
                                            @else
                                            <option value="{{ $pdv->pdv_type_name }}">
                                                {{ $pdv->pdv_type_name }}%
                                            </option>
                                            @endif
                                    @endforeach
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="d-flex justify-content-around align-items-center">
                                <button type="submit" form="insertInvoiceItem" class="btn btn-success"><i class="fas fa-plus"></i></button>
                            </td>
                        </tr>
                        </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
