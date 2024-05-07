<x-user.template-header title="Test Form Vault" sidebarfocusitem="Test Form Vault"/>

<x-alerts/>

<div class="panel flex-down">
    <div class="w-full flex justify-between items-center gap-2">
        <h1 class="w-full">Test Form Vault</h1>
        <form action="" method="get" class="w-full">
            <div class="w-full flex gap-1">
                <x-inputs.text class="basis-full" name="search" value="{{ Request::input('search') }}"/>
                <x-button type="submit" style="primary-filled" text="Search"/>
            </div>
        </form>
        <x-button type="link" style="primary-filled" text="New" link="{{ route('test_form_vault.create') }}"/>
    </div>
</div>

<div class="panel flex-down">
    <table class="table">
        <thead>
            <th>Title</th>
            <th>Description</th>
            <th>Questions</th>
            <th>Points</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach ($test_forms as $form)
                <tr>
                    <td>{{ $form->name }}</td>
                    <td>{{ $form->description }}</td>
                    <td>{{ $form->question_count }}</td>
                    <td>{{ $form->max_points }}</td>
                    <td>{{ $form->created_at }}</td>
                    <td>{{ $form->updated_at }}</td>
                    <td>
                        <div class="flex gap-1">
                            <x-button type="link" style="primary" leadingIcon="pen-to-square" link="{{ route('test_form_vault.edit', $form->id) }}"/>
                            <!-- <form action="{{ route('test_form_vault.export', $form->id) }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $form->id }}">
                                <x-button type="submit" style="primary" leadingIcon="file-export" leadingIconStyle="solid"/>
                            </form> -->
                            <form action="{{ route('test_form_vault.delete', $form->id) }}" method="post" onsubmit="if(!confirm('Permanently delete the test form?')){return false;}">
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
