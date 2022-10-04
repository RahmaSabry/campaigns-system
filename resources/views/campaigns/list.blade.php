
@section('content')
<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
    <a href="{{url('api/campaigns/create')}}" class="btn btn-primary" >Add Campaign</a>
    &nbsp;&nbsp;&nbsp;
    <a href="{{url('/')}}" class="btn btn-primary" >Go Home</a>

    <campaign-list :campaigns="{{$campaigns}}"></campaign-list>
</div>
@endsection
@include('home')
