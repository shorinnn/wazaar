@if (Session::get('success'))
    <div class="alert">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert">{{{ Session::get('error') }}}</div>
@endif

{{ link_to_action("MembersController@index", trans('general.members')) }} | 
{{ link_to_action("MembersController@edit", trans('crud/labels.edit'), $user->id) }}<br />

{{trans('general.user')}}: {{ $user->email }}<br />
{{trans('general.first_name')}}:  {{ $user->first_name }}<br />
{{trans('general.last_name')}}:  {{ $user->last_name }}<br />
{{trans('general.registered')}}:  {{ $user->created_at }} {{ $user->created_at->diffForHumans() }}<br />