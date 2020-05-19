@extends('dashboard')

@section('page', 'category')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.master.css?v=1.1">
    <style>

    </style>
@endsection

@section('content')
    <div class="container --master">
        <div class="content-list">
            <div align="center">
                <a href="/dashboard/category/add">
                    <button class="primary-button" style="padding: 10px 20px;">+ Add category
                    </button>
                </a>
                <div class="studio-list">
                    @foreach($categories as $category)
                        <div class="studio-container">
                            <a href="/dashboard/category/{{ $category['category_id'] }}"
                               style="flex: 1;">
                                <div class="studio">
                                    <div class="name">
                                        {{ $category['category_name'] }}
                                    </div>
                                    <div class="category">
                                        <img class="svg pic" src="{{ $category['category_pic'] }}">
                                    </div>
                                </div>
                            </a>
                            <form method="post" onsubmit="return deleteCategory()"
                                  action="/dashboard/category/{{ $category['category_id'] }}"
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


        </div>
    </div>
@endsection

@section('script')
    <script>
      function deleteCategory() {
        var result = confirm('Confirm to delete?')
        if (!result) {
          return false
        }

      }
    </script>
@endsection