
@section('content')
<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
    <a href="{{url('api/campaigns')}}" class="btn btn-primary" >Campaign list</a>
    &nbsp;&nbsp;&nbsp;
    <a href="{{url('/')}}" class="btn btn-primary" >Go Home</a>
    <app></app>
</div>

@endsection
@include('home')
<script>
    @if(isset($campaign))
        window.campaign = @json($campaign);
    @endif
</script>