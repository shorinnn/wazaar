<tr id='row-{{ $refund->id }} refunded-{{$refund->purchase_id}}'>
    <td> {{ $i }}</td>
    <td>{{ $refund->id }}</td>
    <td>{{ $refund->purchase_id }}</td>
    <td>
        {{ $refund->product->name }}
        @if( !isset( $refund->product->module ) )
        <a href='{{ action( 'CoursesController@show', $refund->product->slug ) }}' target='_blank'>
            @else
            <a href='{{ action( 'CoursesController@show', $refund->product->module->lesson->course->slug ) }}' 
               target='_blank'>
                @endif
                {{ trans('crud/labels.view') }}
                <i class="fa fa-external-link"></i>
            </a>
    </td>
    <td> {{ trans('administration.'.get_class( $refund->product ) ) }}</td>
    <td>
        {{ trans('administration.refunded')}} 
        ¥{{ number_format($refund->purchase_price + $refund->tax  - $refund->balance_used, 
                                            Config::get('custom.currency_decimals')) }}
    </td>
    <td> {{ $refund->created_at }}</td>
</tr>