<x-user.template-header title="Topics" sidebarfocusitem="Question Bank" sidebarfocussubitem="Topics"/>

<x-alerts/>

<div class="panel">
    <div class="w-full flex justify-between">
        <h1>Topics</h1>
        <x-button type="link" style="primary-filled" text="New Topic" link="{{ route('question_bank.create_topic') }}"/>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Assigned</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel quam in maiores. Impedit repudiandae iste minima corporis ab accusantium nobis omnis, fugit beatae natus voluptatibus nesciunt temporibus aut inventore sapiente!</td>
                <td>69</td>
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
