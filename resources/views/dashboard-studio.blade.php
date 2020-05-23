@extends('dashboard')

@section('page', 'studio')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.studio.css?v=1.2">
@endsection

@section('content')
    <div class="studio-wrapper">

        <div class="studio-list">
            @if(!isset($nostudio))
                <div align="center">
                    <a href="/dashboard/studio/add">
                        <button class="primary-button" style="padding: 10px 20px;">+ Add studio
                        </button>
                    </a>
                </div>
            @else
                <div align="center" style="padding: 20px">
                    You don't own any studio.<br>
                    The studio can only be edited by the owner
                </div>
            @endif
            @foreach($studios as $studio)
                <div class="studio-container">
                    <a href="/dashboard/studio/{{ $studio['studio_id'] }}" style="flex: 1;">
                        <div class="studio">
                            <div class="name">
                                <img class="icon" src="{{ $studio['studio_icon'] }}">
                                {{ $studio['studio_name'] }}
                            </div>
                            <div class="category">
                                <img class="svg pic" src="{{ $studio['category_pic'] }}">
                                <span>
                            {{ $studio['category_name'] }}
                            </span>
                            </div>
                        </div>
                    </a>
                    <form method="post" onsubmit="return deleteStudio()"
                          action="/dashboard/studio/{{ $studio['studio_id'] }}"
                          style="margin-left: 10px">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf

                        <button class="btn btn-danger"
                                type="submit">Delete
                        </button>

                    </form>
                </div>
            @endforeach
        </div>

    </div>
@endsection

@section('script')
    <script>
      function deleteStudio() {
        var result = confirm('Confirm to delete?')
        if (!result) {
          return false
        }

      }
    </script>
@endsection