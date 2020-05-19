@extends('dashboard')

@section('page', 'master')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.master.css?v=1.1">
@endsection

@section('content')
    <div class="container">
        <div class="content-list">
            <div align="center">
                <a href="/dashboard/master/add">
                    <button class="primary-button" style="padding: 10px 20px;">+ Add master</button>
                </a>
            </div>
            @foreach($masters as $master)
                <div class="content-container">
                    <a href="/dashboard/master/{{ $master['master_id'] }}" style="flex: 1;">
                        <div class="content">
                            <div class="name">
                                <img class="icon" src="{{ $master['user_pic'] }}">
                                {{ $master['master_name'] }}<br />
                                {{ $master['user_email'] }}
                            </div>
                        </div>
                    </a>
                    <form method="post" onsubmit="return deleteMaster()"
                          action="/dashboard/master/{{ $master['master_id'] }}"
                          style="margin-left: 10px">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('script')
    <script>
      function deleteMaster() {
        var result = confirm('Confirm to delete?')
        if (!result) {
          return false
        }

      }
    </script>
@endsection