@if($message = Session::get('success'))
<div class="alert alert-success">
    <i class="fa fa-check"></i> {!! $message !!}
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger">
    <i class="fa fa-exclamation-triangle"></i> {!! $message !!}
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info">
    <i class="fa fa-exclamation-triangle"></i> {!! $message !!}
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning">
    <i class="fa fa-exclamation-triangle"></i> {!! $message !!}
</div>
@endif