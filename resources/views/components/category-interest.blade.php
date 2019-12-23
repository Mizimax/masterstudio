@php
    $user = !empty($user) ? $user : Auth::user();

    //if($user) {
    $userCategories = \App\UserCategory::from('user_category as uc')
                                        ->join('users as us', 'uc.user_id', 'us.user_id')
                                        ->join('categories as cg', 'uc.category_id', 'cg.category_id')
                                        ->where('uc.user_id', $user['user_id'])
                                        ->get();
//}

    $categories = \App\UserCategory::from('categories as cg')
                                        ->whereNotIn('cg.category_id', function($query) use ($user){
                                            $query->from('user_category as uc')
                                                  ->where('uc.user_id', $user['user_id'])
                                                  ->select('uc.category_id');
                                        })
                                        ->get();


    $me = empty($me) ? 1 : $me;

@endphp
@if(!$userCategories->isEmpty() || $me == 1)
    <div class="category-interest">
        <div class="interest-group">
            @foreach($userCategories as $userCategory)
                <div class="interest-activity{{ $loop->first && !empty($active) && $active ? ' active' : '' }}"
                     tabindex="-1">
                    <div class="icon">
                        <img class="svg" src="{{ $userCategory['category_pic'] }}">
                    </div>
                    <div class="name">{{ $userCategory['category_name'] }}</div>
                    <input id="category-id" type="hidden"
                           value="{{ $userCategory['category_id'] }}">
                </div>
            @endforeach
        </div>
        @if($me == 1)
            <div class="add-interest-activity" tabindex="-1">
                <div class="icon">
                    <img class="svg" src="/img/icon/plus.svg">
                </div>
                <div class="name">Add interest</div>
                <div class="search-dropdown">
                    {{ $categories->isEmpty() ? 'You already selected all categories.' : '' }}
                    @foreach($categories as $category)
                        <div class="search-result">
                            <input type="hidden" class="category-id"
                                   value="{{ $category['category_id'] }}">
                            <img class="svg" src="{{ $category['category_pic'] }}">
                            <span class="category">{{ $category['category_name'] }}</span>
                            <span class="add">Add</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endif
