<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InvoiceItem extends Component
{
    public $item;

    public $pdvTypes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
   public function __construct( $pdvTypes, $item = null )
    {
        $this->pdvTypes = $pdvTypes;

        $this->item = $item;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.invoice-item');
    }
}
