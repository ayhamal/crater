<table width="100%" class="items-table" cellspacing="0" border="0">
    <tr class="item-table-heading-row">
        <th width="2%" class="item-table-heading text-right pr-20">#</th>
        <th width="40%" class="item-table-heading text-left pl-0">Items</th>
        <th class="item-table-heading text-right pr-20">Cantidad</th>
        <th class="item-table-heading text-right pr-20">Precio</th>
        @if($estimate->discount_per_item === 'YES')
        <th class="item-table-heading text-right pl-10">Descuento</th>
        @endif
        <th class="item-table-heading text-right">Importe </th>
    </tr>
    @php
        $index = 1
    @endphp
    @foreach ($estimate->items as $item)
        <tr class="item-row">
            <td
                class="item-cell text-right pr-20"
                style="vertical-align: top;"
            >
                {{$index}}
            </td>
            <td
                class="item-cell text-left pl-0"
            >
                <span>{{ $item->name }}</span><br>
                <span
                    class="item-description"
                >
                    {!! nl2br(htmlspecialchars($item->description)) !!}
                </span>
            </td>
            <td
                class="item-cell text-right pr-20"
                style="vertical-align: top;"
            >
                {{$item->quantity}}
            </td>
            <td
                class="item-cell text-right pr-20"
                style="vertical-align: top;"
            >
                {!! format_money_pdf($item->price, $estimate->user->currency) !!}
            </td>
            @if($estimate->discount_per_item === 'YES')
                <td class="item-cell text-right pl-10" style="vertical-align: top;">
                    @if($item->discount_type === 'fixed')
                        {!! format_money_pdf($item->discount_val, $estimate->user->currency) !!}
                    @endif
                    @if($item->discount_type === 'percentage')
                        {{$item->discount}}%
                    @endif
                </td>
            @endif
            <td class="item-cell text-right" style="vertical-align: top;">
                {!! format_money_pdf($item->total, $estimate->user->currency) !!}
            </td>
        </tr>
        @php
            $index += 1
        @endphp
    @endforeach
</table>

<hr class="item-cell-table-hr">

<div class="total-display-container">
    <table width="100%" cellspacing="0px" border="0" class="total-display-table @if(count($estimate->items) > 12) page-break @endif">
        <tr>
            <td class="border-0 total-table-attribute-label">Subtotal</td>
            <td class="border-0 item-cell total-table-attribute-value ">{!! format_money_pdf($estimate->sub_total, $estimate->user->currency) !!}</td>
        </tr>

        @if ($estimate->tax_per_item === 'YES')
            @for ($i = 0; $i < count($labels); $i++)
                <tr>
                    <td class="border-0 total-table-attribute-label">
                        {{$labels[$i]}}
                    </td>
                    <td class="border-0 item-cell  total-table-attribute-value">
                        {!! format_money_pdf($taxes[$i], $estimate->user->currency) !!}
                    </td>
                </tr>
            @endfor
        @else
            @foreach ($estimate->taxes as $tax)
                <tr>
                    <td class="border-0 total-table-attribute-label">
                        {{$tax->name.' ('.$tax->percent.'%)'}}
                    </td>
                    <td class="border-0 item-cell total-table-attribute-value" >
                        {!! format_money_pdf($tax->amount, $estimate->user->currency) !!}
                    </td>
                </tr>
            @endforeach
        @endif

        @if ($estimate->discount_per_item === 'NO')
            <tr>
                <td class="border-0 total-table-attribute-label pl-10">
                    @if($estimate->discount_type === 'fixed')
                        Descuento
                    @endif
                    @if($estimate->discount_type === 'percentage')
                        Descuento ({{$estimate->discount}}%)
                    @endif
                </td>
                <td class="border-0 item-cell total-table-attribute-value text-right">
                    @if($estimate->discount_type === 'fixed')
                        {!! format_money_pdf($estimate->discount_val, $estimate->user->currency) !!}
                    @endif
                    @if($estimate->discount_type === 'percentage')
                        {!! format_money_pdf($estimate->discount_val, $estimate->user->currency) !!}
                    @endif
                </td>
            </tr>
        @endif
        <tr>
            <td class="py-3"></td>
            <td class="py-3"></td>
        </tr>
        <tr>
            <td class="border-0 total-border-left total-table-attribute-label">Total</td>
            <td class="border-0 total-border-right item-cell py-8 total-table-attribute-value text-primary">
                {!! format_money_pdf($estimate->total, $estimate->user->currency)!!}
            </td>
        </tr>
    </table>
</div>
