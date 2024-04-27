<x-user.template-header title="Student groups" sidebarfocusitem="Student Groups"/>

<x-alerts/>

@foreach ($groups as $index=>$group)
    <div class="panel flex-down">
        <h2>{{ $group->name }}</h2>
        @foreach ($group_users[$index] as $user)
            <p>{{ $user->username }}</p>
        @endforeach
    </div>
@endforeach

<x-user.template-footer/>