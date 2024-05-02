<x-user.template-header title="Test Responses" sidebarfocusitem="Responses"/>

<x-alerts/>

@dump($responses)

<div class="panel flex-down">
    <div class="flex justify-between">
        <h1>Responses</h1>
        <form action="" method="get" class="flex gap-2 items-center">
            <x-inputs.select name="test" :options="$tests" selected="{{ $id }}"/>
            <x-button type="submit" style="primary-filled" text="View"/>
        </form>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Points</th>
                <th>Grade</th>
                <th>Submited at</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($responses as $response)
                <tr>
                    <td>{{ $response->username }}</td>
                    <td>{{ $response->points }}</td>
                    <td>{{ $response->grade }}</td>
                    <td>{{ $response->created_at }}</td>
                    <td class="flex">
                        <x-button type="link" style="primary" leadingIcon="eye" link="#"/>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="panel flex-down">
    <h2>Analysis</h2>
    <h3>Overall</h3>
    <h3>Per question</h3>
</div>

<x-user.template-footer/>