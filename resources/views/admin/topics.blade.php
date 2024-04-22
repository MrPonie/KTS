<x-user.template-header title="Topics" sidebarfocusitem="Questions" sidebarfocussubitem="All topics"/>

<x-alerts/>

<div class="panel flex-down">
    <div class="w-full flex justify-between">
        <h1>Topics</h1>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Craeted by</th>
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