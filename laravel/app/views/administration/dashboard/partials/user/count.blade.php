<h2>{{number_format($userStats['usersTotal'])}}</h2>
<ul>
    @foreach($userStats['users'] as $user)
        <li class="clearfix">
            <span>{{$user['label']}}</span>
            <div>
                <div class="progress" style="width: {{$user['percentage']}}%"></div>
            </div>
            <em>{{number_format($user[$frequency]['total_users'])}}</em>
        </li>
    @endforeach
</ul>
