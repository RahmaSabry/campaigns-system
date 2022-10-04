@section('content')
    <a href="{{url('api/campaigns')}}" class="btn btn-primary" >Campaign list</a>
    &nbsp;&nbsp;&nbsp;
    <a href="{{url('api/campaigns/create')}}" class="btn btn-primary" >Add new Campaign</a>
</div>
@endsection
@include('home')
