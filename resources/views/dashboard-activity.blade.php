@extends('dashboard')

@section('page', 'activity')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.master.css">
@endsection

@section('content')
    <div class="container">
        <div class="content-list">
            @if(count($activities) != 0)
                <div align="center">
                    <a href="/dashboard/activity/add">
                        <button class="primary-button" style="padding: 10px 20px;">+ Add activity
                        </button>
                    </a>
                </div>
            @else
                <div align="center" style="padding: 20px">
                    You don't own any activity.<br>
                    The activity can only be edited by the owner
                </div>
            @endif
            @foreach($activities as $activity)
                <div class="content-container">
                    <a href="/dashboard/activity/{{ $activity['activity_id'] }}" style="flex: 1;">
                        <div class="content">
                            <div class="name">
                                {{ $activity['activity_name'] }}
                            </div>
                            <div class="master">
                                {{ $activity['master_name'] }}
                            </div>
                        </div>
                    </a>
                    <form method="post" onsubmit="return deleteActivity()"
                          action="/dashboard/activity/{{ $activity['activity_id'] }}"
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
      function deleteActivity() {
        var result = confirm('Confirm to delete?')
        if (!result) {
          return false
        }

      }
    </script>
@endsection