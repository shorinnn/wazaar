@if (Session::get('success'))
    <div class="alert">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert">{{{ Session::get('error') }}}</div>
@endif

{{ link_to_action("MembersController@index", trans('general.members')) }} | 
{{ link_to_action("MembersController@show", trans('crud/labels.view'), $user->id) }}<br />

{{ Form::model($user, ['action' => ['MembersController@update', $user->id], 'method' => 'PUT', 'id' =>'edit-form'])}}
{{trans('general.user')}}: {{ Form::text('email') }}<br />
{{trans('general.first_name')}}: {{ Form::text('first_name') }}<br />
{{trans('general.last_name')}}: {{ Form::text('last_name') }}<br />
{{trans('general.registered')}}: {{ $user->created_at }} {{ $user->created_at->diffForHumans() }}<br />
{{ Form::submit( trans('crud/labels.update') ) }}
{{ Form::close() }}