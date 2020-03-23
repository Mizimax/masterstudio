@extends('dashboard')

@section('page', 'user')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.user.css">
@endsection

@section('content')
    <div class="container">
        <div class="content-list">
            <div align="center">
                <a href="/dashboard/user/add">
                    <button class="primary-button" style="padding: 10px 20px;">+ Add user</button>
                </a>
            </div>
            @foreach($users as $user)
                <div class="content-container">
                    <a href="/dashboard/user/{{ $user['user_id'] }}" style="flex: 1;">
                        <div class="content">
                            <div class="name">
                                <img class="icon" src="{{ $user['user_pic'] }}">
                                {{ $user['user_name'] }}
                                {{ $user['user_email'] }}
                            </div>
                        </div>
                    </a>
                    <form method="post" onsubmit="return deleteUser()"
                          action="/dashboard/user/{{ $user['user_id'] }}"
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
      function deleteUser() {
        var result = confirm('Confirm to delete?')
        if (!result) {
          return false
        }

      }
    </script>
@endsection
