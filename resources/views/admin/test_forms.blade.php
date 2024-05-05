<x-user.template-header title="Test forms" sidebarfocusitem="Test Forms"/>

<x-alerts/>

<div class="panel flex-down">
    <div class="w-full flex justify-between">
        <h1>Test forms</h1>
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
                <th>Title</th>
                <th>Created by</th>
                <th>Description</th>
                <th>Question count</th>
                <th>Max points</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($forms as $form)
                <tr>
                    <td>{{ $form->name }}</td>
                    <td>{{ $form->user }}</td>
                    <td>{{ $form->description }}</td>
                    <td>{{ $form->question_count }}</td>
                    <td>{{ $form->max_points }}</td>
                    <td>{{ $form->created_at }}</td>
                    <td>{{ $form->updated_at }}</td>
                    <td>
                        <div class="flex gap-1 items-center">
                            <x-button type="link" style="primary" leadingIcon="eye" link="#"/>
                            <form action="" method="post" onsubmit="if(!confirm('Are you sure you want to delete this question?')) {return false;}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $form->id }}">
                                <x-button type="submit" style="error" leadingIcon="x"/>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-user.template-footer/>