<x-user.template-header title="Undone assigned tests" sidebarfocusitem="Assigned Tests" sidebarfocussubitem="Undone assigned tests"/>

<x-alerts/>

<div class="panel flex-down">
    <div class="w-full flex justify-between items-center gap-2">
        <h1 class="w-full">Assigned tests</h1>
        <form action="" method="get" class="w-full">
            <div class="w-full flex gap-1">
                <x-inputs.text class="basis-full" name="search" value="{{ Request::input('search') }}"/>
                <x-button type="submit" style="primary-filled" text="Search"/>
            </div>
        </form>
    </div>
</div>

<div class="panel flex-down">
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Question count</th>
                <th>Max Points</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tests as $index=>$test)
                <tr>
                    <td>{{ $test->name }}</td>
                    <td>{{ $test->question_count }}</td>
                    <td>{{ $test->max_points }}</td>
                    <td>
                        <div class="flex gap-1">
                            <x-button type="link" style="primary" leadingIcon="pen" leadingIconStyle="solid" title="Answer" link="{{ route('user.repond_to_test', $test->id) }}"/>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-user.template-footer/>
