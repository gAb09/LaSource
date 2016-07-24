@section('content')
@parent
<div style="background-color:cornsilk">
@foreach($livraisons as $livraison)
LIVRAISON {{$livraison['name']}} A VENIR<br />
@endforeach
</div>
@stop

@section('script')
@parent
<script src="/js/livraison.js"></script>
@stop
