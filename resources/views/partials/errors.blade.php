@if (isset($errors) && count($errors) == 1)
    <div class="alert alert-danger mb-3">
        @foreach ($errors->all() as $error)
            {!! $error !!}
        @endforeach
    </div>
@elseif(isset($errors) && count($errors) > 1)
    <div class="alert alert-danger mb-3">
        <p style="margin: 0;">
            @foreach ($errors->all() as $error)
                {!! $error !!}<br>
            @endforeach
        </p>
    </div>
@endif
@if(session('alert'))
    <div class="alert alert-{{ session('alert') }} mb-3">
        {!! session('message') !!}
    </div>
@endif
@if(session('status'))
    <div class="alert alert-warning mb-3">
        {!! session('status') !!}
    </div>
@endif
