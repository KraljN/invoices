<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Repository\InvoiceRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class InvoiceController extends BaseController
{
    private $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allUnpaidInvoices = Invoice::with('invoiceStatus')->whereHas('invoiceStatus', function (Builder $query) {
            $query->where('id', Config::get('constants.invoice_status.unpaid'));
        })->get();
        $this->invoiceRepository->checkIfOverdue($allUnpaidInvoices);
        $this->data['invoiceStatuses'] = $this->invoiceRepository->getInvoicesStatuses();
        $this->data['invoices'] = $this->invoiceRepository->getInvoices();
        foreach ($this->data['invoices'] as $invoice){
            $invoice->total = $this->invoiceRepository->countInvoiceDebt($invoice);
            $invoice->debt =  $this->invoiceRepository->countDebt($invoice);
        }
        return view('pages.home', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
