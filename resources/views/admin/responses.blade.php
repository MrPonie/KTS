<x-user.template-header title="Responses" sidebarfocusitem="Responses"/>

<x-alerts/>

<div class="panel flex-down">
    <table class="table">
        <thead>
            <tr>
                <th>Created by</th>
                <th>Test title</th>
                <th>Points</th>
                <th>Grade</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($responses as $response)
                <tr>
                    <td>{{ $response->username }}</td>
                    <td>{{ $response->name }}</td>
                    <td>{{ $response->points }}</td>
                    <td>
                        @if ($response->passed)
                            <span class="text-green-500">{{ $response->grade }}</span>
                        @else
                            <span class="text-red-500">{{ $response->grade }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex gap-1">
                            <x-button type="link" style="primary" leadingIcon="eye" link="#"/>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-user.template-footer/>