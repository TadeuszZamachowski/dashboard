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
@if(session()->has('error'))
<style>
    .flash {
        color: red;
    }
</style>
<div>
    <p class="flash">
        {{session('error')}}
    </p>
</div>
@endif