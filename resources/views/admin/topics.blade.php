<x-user.template-header title="Topics" sidebarfocusitem="Questions" sidebarfocussubitem="All topics"/>

<x-alerts/>

<div class="panel flex-down">
    <div class="w-full flex justify-between">
        <h1>Topics</h1>
    </div>
    <form action="" method="get" class="flex gap-2">
        <x-inputs.select name="by" label="Created by" :options="$teachers" selected="{{ Request::input('by') }}" class="w-full"/>
        <x-inputs.text type="search" name="search" label="Search" value="{{ Request::input('search') }}" class="w-full"/>
        <x-button type="submit" style="primary-filled" text="Filter"/>
    </form>
</div>

<div class="panel flex-down">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Created by</th>
                <th>Desctiption</th>
                <th>Question count</th>
                <th>Created at</th>
                <th>Updated at</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topics as $topic)
                <tr>
                    <td>{{ $topic->name }}</td>
                    <td>{{ $topic->user }}</td>
                    <td>{{ $topic->description }}</td>
                    <td>{{ $topic->question_count }}</td>
                    <td>{{ $topic->created_at }}</td>
                    <td>{{ $topic->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-user.template-footer/>