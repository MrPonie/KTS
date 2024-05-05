<x-user.template-header title="Test Responses" sidebarfocusitem="Responses"/>

<x-alerts/>

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
            @if ($responses)
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
            @endif
        </tbody>
    </table>
</div>

@if ($responses_count)
    <div class="panel flex-down">
        <h1>Analysis</h1>
        <h2 class="mb-4 text-center">Overall</h2>
        <div class="grid grid-cols-6 text-center">
            <p class="font-bold text-gray-900">Min</p>
            <p class="font-bold text-gray-900">Max</p>
            <p class="font-bold text-gray-900">Range</p>
            <p class="font-bold text-gray-900">Mean</p>
            <p class="font-bold text-gray-900">Median</p>
            <p class="font-bold text-gray-900">Std. Deviation</p>
            <p>{{ $min }}</p>
            <p>{{ $max }}</p>
            <p>{{ $range }}</p>
            <p>{{ $mean }}</p>
            <p>{{ $median }}</p>
            <p>{{ $std_deviation }}</p>
        </div>
        <h2 class="my-4 text-center">Per question</h2>
        <div class="flex-down">
            @foreach ($test_question_analysis_data as $index=>$question)
                <div class="mt-4 flex-down">
                    <p class="text-gray-900 font-bold">{{ $index }}. {{ $question['question'] }}</p>
                    @if ($question['type'] == 0 || $question['type'] == 1)
                        <table>
                            <tbody>
                            @foreach ($question['input_json'] as $input)
                                <tr>
                                    <td class="w-1/2">{{ $input->text }}</td>
                                    <td class="pl-2 w-1/2">
                                        <div class="flex items-center gap-1">
                                            <div class="bg-purple-500 h-4 rounded" style="width: {{ $input->selected / $responses_count * 100 }}%;"></div>
                                            {{ $input->selected }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>TODO</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif

<x-user.template-footer/>