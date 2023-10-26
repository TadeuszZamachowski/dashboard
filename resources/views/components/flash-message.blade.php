@if(session()->has('success'))
<style>
    .flash {
        color: green;
        font-weight: bold;
        font-size: 24px;
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
        font-weight: bold;
        font-size: 24px;
    }
</style>
<div>
    <p class="flash">
        {{session('error')}}
    </p>
</div>
@endif