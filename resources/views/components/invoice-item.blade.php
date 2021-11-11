<form
    @if($item)
        action="{{ route('invoice-items.update', $item->id) }}"
    @else
        action="{{ route('invoice-items.store') }}"
    @endif
    method="POST">
    <tr>
        <td>
            <textarea class="form-control" name="description"cols="20" rows="2">@if($item){{ $item->description }}@endif</textarea>
        </td>
        <td>
            <input class="form-control"  @if($item)value="{{ $item->quantity }}" @endif min="0" type="number"/>
        </td>
        <td>
            <input class="form-control" @if($item) value="{{ $item->price }}" @endif type="text"/>
        </td>
        <td>
            <select name="status" class="form-select">
                @foreach($pdvTypes as $pdv)
                    @if( $pdv->pdv_type_name == 0)
                        <option value="0">
                            None
                        </option>
                    @else
                        <option @if($item &&  $item->pdv_type_name == $pdv->pdv_type_name) selected="selected" @endif value="{{ $pdv->pdv_type_name }}">
                            {{ $pdv->pdv_type_name }}%
                        </option>
                    @endif
                @endforeach
            </select>
        </td>
        <td>
            @if($item)
                {{ ($item->quantity * $item->price) - ($item->quantity * $item->price)  *  $item->pdv_type_name / 100 }} RSD
            @endif
        </td>
        <td>
            @if($item)
                {{ $item->pdv_type_name / 100 }} RSD
            @endif
        </td>
        <td>
            @if($item)
                {{ $item->quantity * $item->price }} RSD
            @endif
        </td>
        <td class="d-flex justify-content-around align-items-center">
            @if($item)
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
            @else
                <button type="submit" form="insertInvoiceItem" class="btn btn-success"><i class="fas fa-plus"></i></button>
            @endif
        </td>
    </tr>
</form>
