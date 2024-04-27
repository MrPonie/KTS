<x-user.template-header title="Topics" sidebarfocusitem="Question Bank" sidebarfocussubitem="Topics"/>

<x-alerts/>

<div class="panel flex-down">
    <div class="w-full flex justify-between items-center gap-2">
        <h1 class="w-full">Topics</h1>
        <form action="" method="get" class="w-full">
            <div class="w-full flex gap-1">
                <x-inputs.text class="basis-full" name="search" value="{{ Request::input('search') }}"/>
                <x-button type="submit" style="primary-filled" text="Search"/>
            </div>
        </form>
        <x-button type="link" style="primary-filled" text="New" link="{{ route('question_bank.create_topic') }}"/>
    </div>
</div>

<div class="panel">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Assigned</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topics as $topic)
                <tr>
                    <td>{{ $topic->name }}</td>
                    <td>{{ $topic->description }}</td>
                    <td>{{ $topic->question_count }}</td>
                    <td>{{ $topic->created_at }}</td>
                    <td>{{ $topic->updated_at }}</td>
                    <td>
                        <div class="flex gap-1">
                            <x-button type="link" link="{{ route('question_bank.edit_topic', $topic->id) }}" style="primary" leadingIcon="pen-to-square"/>
                            <x-button type="link" link="{{ route('question_bank.create_topic', $topic->id) }}" style="error" leadingIcon="x"/>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-user.template-footer/>
