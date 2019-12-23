@foreach($masters as $master)
    <img src="{{$master['user_pic']}}" class="master"
         onclick="window.location.href='/master/{{ $master['master_id'] }}'">
@endforeach