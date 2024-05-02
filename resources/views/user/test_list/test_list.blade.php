<x-user.template-header title="Test List" sidebarfocusitem="Test List"/>

<x-alerts/>

<div class="panel flex-down">
    <div class="flex justify-between">
        <h1>Test List</h1>
        <x-button type="link" style="primary-filled" text="Create" link="{{ route('test_list.create') }}"/>
    </div>
    <form action="" method="get" class="flex gap-2">
        <x-inputs.select name="active" label="Is active" :options="[null=>'None',true=>'Active',false=>'Inactive']" selected="{{ Request::input('active') }}" class="w-full"/>
        <x-inputs.text type="search" name="search" label="Search" value="{{ Request::input('search') }}" class="w-full"/>
        <x-button type="submit" style="primary-filled" text="Filter"/>
    </form>
</div>

<div class="panel flex-down">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Is active</th>
                <th>Users assigned</th>
                <th>Responses</th>
                <th>Question count</th>
                <th>Max Points</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tests as $test)
                <tr>
                    <td>{{ $test->name }}</td>
                    <td>
                        @if ($test->is_active)
                            <span class="text-green-500">Active</span>
                        @else
                            <span class="text-red-500">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $test->user_count }}</td>
                    <td>{{ $test->responses }}</td>
                    <td>{{ $test->question_count }}</td>
                    <td>{{ $test->max_points }}</td>
                    <td>{{ $test->created_at }}</td>
                    <td>{{ $test->updated_at }}</td>
                    <td>
                        <div class="flex gap-1">
                            <x-button type="link" style="primary" leadingIcon="comment" link="{{ route('test_responses', $test->id) }}" title="View reponses"/>
                            @if ($test->is_active)
                                <form action="{{ route('test_list.stop', $test->id) }}" method="post" onsubmit="return confirm('Are you sure you want to deactivate this test?')">
                                    @csrf
                                    <x-button type="submit" style="error" leadingIcon="ban" leadingIconStyle="solid"/>
                                </form>
                            @else
                                <form action="{{ route('test_list.start', $test->id) }}" method="post" onsubmit="return confirm('Are you sure you want to activate this test?')">
                                    @csrf
                                    <x-button type="submit" style="success" leadingIcon="circle"/>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-user.template-footer/>
