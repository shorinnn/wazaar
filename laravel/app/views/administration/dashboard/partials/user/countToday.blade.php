<h2>{{number_format($userStats['usersTotal'])}}</h2>
<ul>
    @foreach($userStats['users'] as $user)
        <li id="monday" class="clearfix">
            <span>{{$user['label']}}</span>
            <div>
                <div class="progress" style="width: {{$user['percentage']}}%"></div>
            </div>
            <em>¥{{number_format($user['day']['total_users'])}}</em>
        </li>
    @endforeach
</ul>
