@section('content')
@parent
<div style="background-color:cornsilk">
@foreach($livraisons as $livraison)
LIVRAISON {{$livraison['name']}} A VENIR<br />
@endforeach
</div>
@endsection

@section('script')
@parent
<script src="/js/livraison.js"></script>
@endsection
