<x-user.template-header title="Tests" sidebarfocusitem="Tests"/>

<x-alerts/>

<div class="panel flex-down">
    <div class="flex justify-between items-center">
        <h1>Test List</h1>
    </div>
    <form action="" method="get" class="flex gap-2">
        <x-inputs.select name="by" label="Created by" :options="$teachers" selected="{{ Request::input('by') }}" class="w-full"/>
        <x-inputs.select name="active" label="Is active" :options="[null=>'None', true=>'Active', false=>'Inactive']" selected="{{ Request::input('active') }}" class="w-full"/>
        <x-inputs.text type="search" name="search" label="Search" value="{{ Request::input('search') }}" class="w-full"/>
        <x-button type="submit" style="primary-filled" text="Filter"/>
    </form>
</div>

<div class="panel">
    <table class="table">
        <thead>
            <th>Title</th>
            <th>Created by</th>
            <th>Is active</th>
            <th>Question count</th>
            <th>Max points</th>
            <th>Student count</th>
            <th>Created at</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach ($tests as $test)
                <tr>
                    <td>{{ $test->name }}</td>
                    <td>{{ $test->user }}</td>
                    <td>{{ $test->is_active }}</td>
                    <td>{{ $test->question_count }}</td>
                    <td>{{ $test->max_points }}</td>
                    <td></td>
                    <td>{{ $test->created_at }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-user.template-footer/>