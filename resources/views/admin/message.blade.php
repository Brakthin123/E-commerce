@if(session()->has('message'))

<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert"
    aria-hidden="true">x</button>

    {{session()->get('message')}}

</div>

@endif
