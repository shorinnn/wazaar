@if (Session::get('success'))
    <div class="alert">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert">{{{ Session::get('error') }}}</div>
@endif

<table>
@foreach($members as $member)
<tr>
    <td>
    {{$member->email}}
    </td>
    <td>{{link_to_action('MembersController@show', trans('crud/labels.view'), $member->id)}}</td>
    <td>{{link_to_action('MembersController@edit', trans('crud/labels.edit'), $member->id)}} </td>
    <td>
        {{ Form::open(array('action' => array('MembersController@destroy', $member->id), 'method' => 'delete')) }}
        <button type="submit" >{{trans('crud/labels.delete')}}</button>
        {{ Form::close() }}
    </td>
    <br />
@endforeach
</table>
{{$members->links()}}