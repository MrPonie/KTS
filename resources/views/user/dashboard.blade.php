<x-user.template-header title="Dashboard" sidebarfocusitem="Dashboard"/>

<x-alerts/>

<div class="grid grid-cols-4 gap-4">
    @if (has_permission('can_receive_tests'))
        <x-dashboard-panel title="Assigned tests">
            <p class="mb-2 text-center text-xl text-black">Total: {{ $assigned_tests }}</p>
            <div class="grid grid-cols-2">
                <div class="flex flex-col items-center">
                    <p>Answered</p>
                    <p class="text-green-500 text-5xl">{{ $answered_assigned_tests }}</p>
                </div>
                <div class="flex flex-col items-center">
                    <p>Unanswered</p>
                    <p class="text-red-500 text-5xl">{{ $unanswered_assigned_tests }}</p>
                </div>
            </div>
        </x-dashboard-panel>
    @endif
    @if (has_permission('has_question_bank'))
        <x-dashboard-panel title="Question bank">
            <div class="grid grid-cols-2">
                <div class="">
                    <p class="text-center text-xl text-black">Questions</p>
                    <p class="text-center text-5xl text-black">{{ $question_bank_questions }}</p>
                </div>
                <div class="">
                    <p class="text-center text-xl text-black">Topics</p>
                    <p class="text-center text-5xl text-black">{{ $question_bank_topics }}</p>
                </div>
            </div>
        </x-dashboard-panel>
    @endif
    @if (has_permission('has_test_form_vault'))
        <x-dashboard-panel title="Test form vault">
            <div class="grid grid-cols-2">
                <div class="">
                    <p class="text-center text-xl text-black">Test forms</p>
                    <p class="text-center text-5xl text-black">{{ $test_form_vault_forms }}</p>
                </div>
                <div class="">
                    <p class="text-center text-xl text-black">Test forms used</p>
                    <p class="text-center text-5xl text-black">{{ $test_form_vault_forms_used }}</p>
                </div>
            </div>
        </x-dashboard-panel>
    @endif
    @if (has_permission('has_tests_list'))
        <x-dashboard-panel title="Tests list">
            <p class="mb-2 text-center text-xl text-black">Total: {{ $test_list_tests }}</p>
            <div class="grid grid-cols-2">
                <div class="flex flex-col items-center">
                    <p>Active</p>
                    <p class="text-green-500 text-5xl">{{ $test_list_active }}</p>
                </div>
                <div class="flex flex-col items-center">
                    <p>Inactive</p>
                    <p class="text-red-500 text-5xl">{{ $test_list_inactive }}</p>
                </div>
            </div>
        </x-dashboard-panel>
        <x-dashboard-panel title="Responses">
            <p class="mb-2 text-center text-xl text-black">Total: {{ $received_responses }}</p>
        </x-dashboard-panel>
    @endif
    @if (has_permission('view_users'))
        <x-dashboard-panel title="Users">
            <div class="flex-down">
                <table>
                    <tbody>
                        <tr>
                            <td><p>Online</p></td>
                            <td class="pl-2 w-full">
                                <div class="flex items-center gap-1">
                                    <div class="bg-purple-500 h-4 rounded" style="width: {{ $users_online / ($users?:1) * 100 }}%;"></div>
                                    {{ $users_online }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><p>Active</p></td>
                            <td class="pl-2 w-full">
                                <div class="flex items-center gap-1">
                                    <div class="bg-green-500 h-4 rounded" style="width: {{ $users_active / ($users?:1) * 100 }}%;"></div>
                                    {{ $users_active }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><p>Inactive</p></td>
                            <td class="pl-2 w-full">
                                <div class="flex items-center gap-1">
                                    <div class="bg-red-500 h-4 rounded" style="width: {{ $users_inactive / ($users?:1) * 100 }}%;"></div>
                                    {{ $users_inactive }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><p>Total</p></td>
                            <td class="pl-2">{{ $users }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-dashboard-panel>
    @endif
    @if (has_permission('view_questions'))
        <x-dashboard-panel title="Questions">
            <p class="mb-2 text-center text-xl text-black">Total: {{ $questions }}</p>
        </x-dashboard-panel>
    @endif
    @if (has_permission('view_test_forms'))
        <x-dashboard-panel title="Test forms">
            <p class="mb-2 text-center text-xl text-black">Total: {{ $test_forms }}</p>
        </x-dashboard-panel>
    @endif
    @if (has_permission('view_tests'))
        <x-dashboard-panel title="Tests">
            <p class="mb-2 text-center text-xl text-black">Total: {{ $tests }}</p>
            <div class="grid grid-cols-2">
                <div class="flex flex-col items-center">
                    <p>Active</p>
                    <p class="text-green-500 text-5xl">{{ $test_active }}</p>
                </div>
                <div class="flex flex-col items-center">
                    <p>Inactive</p>
                    <p class="text-red-500 text-5xl">{{ $test_inactive }}</p>
                </div>
            </div>
        </x-dashboard-panel>
    @endif
    @if (has_permission('view_responses'))
        <x-dashboard-panel title="Responses">
            <p class="mb-2 text-center text-xl text-black">Total: {{ $responses }}</p>
        </x-dashboard-panel>
    @endif
</div>

<x-user.template-footer/>