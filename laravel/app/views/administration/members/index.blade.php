@if (Session::get('success'))
    <div class="alert">{{{ Session::get('success') }}}</div>
@endif
<table>
@foreach($members as $member)
<tr>
    <td>
    {{$member->email}}
    </td>
    <td>{{link_to_action('MembersController@show', 'View', $member->id)}}</td>
    <td>{{link_to_action('MembersController@edit', 'Edit', $member->id)}} </td>
    <td>
        {{ Form::open(array('action' => array('MembersController@destroy', $member->id), 'method' => 'delete')) }}
        <button type="submit" >Delete User</button>
        {{ Form::close() }}
    </td>
    <br />
@endforeach
</table>
{{$members->links()}}