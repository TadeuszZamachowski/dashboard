@if(session()->has('success'))
<style>
    .flash {
        color: green;
    }
</style>
<div>
    <p class="flash">
        {{session('success')}}
    </p>
</div>
@endif