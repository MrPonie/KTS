<div class="alert-{{ $type }} flex justify-between items-center">
    <p>{{ $message }}</p>
    <button onclick="this.parentElement.style.display='none'"><x-icon icon="x" style="solid"/></button>
</div>