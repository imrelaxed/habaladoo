@if(Session::has('notice'))
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('notice') }}
    </div>
@endif