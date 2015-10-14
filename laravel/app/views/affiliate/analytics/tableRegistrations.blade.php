<table class="table">
    <thead>
    <th>{{trans('analytics.date')}}</th>
    <th>{{trans('analytics.ltcRegistrations')}}</th>
    <th>{{trans('analytics.affiliateRegistrations')}}</th>

    </thead>

    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{$user->date}}</td>
            <td>{{$user->ltc_registrations}}</td>
            <td>{{$user->second_tier_affs}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

{{$users->links()}}