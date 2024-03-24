<x-user.template-header title="Question bank" sidebarfocusitem="Question Bank"/>

<x-alerts/>

<div class="panel">
    <div class="w-full flex justify-between">
        <h1>Questions</h1>
        <x-button type="link" style="primary-filled" text="New Question" link="{{ route('question_bank.create_question') }}"/>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Question</th>
                <th>Type</th>
                <th>Topics</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel quam in maiores. Impedit repudiandae iste minima corporis ab accusantium nobis omnis, fugit beatae natus voluptatibus nesciunt temporibus aut inventore sapiente!</td>
                <td>
                    @switch(0)
                        @case(0)
                            Single select
                            @break
                        @case(1)
                            Multi-select
                            @break
                        @case(1)
                            Text input
                            @break
                        @default
                            Unknown
                    @endswitch
                </td>
                <td>
                    <div class="flex flex-wrap gap-1">
                        <span class="bg-gray-200 rounded p-1">Topic name</span>
                        <span class="bg-gray-200 rounded p-1">Topic name</span>
                    </div>
                </td>
                <td>2024-03-24 14:52</td>
                <td>2024-03-24 14:52</td>
                <td>
                    <div class="flex gap-1">
                        <x-button style="primary" leadingIcon="pen-to-square"/>
                        <x-button style="error" leadingIcon="x"/>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<x-user.template-footer/>
