<div class="flex-down">
    <x-inputs.textarea name="question" label="Question" value="{{ $question }}"/>
    <div class="flex flex-col gap-1">
        <label>Allowed file types</label>
        <div class="flex flex-col gap-1 p-2 border border-gray-200 rounded">
            <label><input type="checkbox"> Image</label>
            <label><input type="checkbox"> Audio</label>
            <label><input type="checkbox"> Video</label>
            <label><input type="checkbox"> Document</label>
            <label><input type="checkbox"> Binary</label>
        </div>
    </div>    
</div>
