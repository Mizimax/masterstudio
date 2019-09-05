@extends('app')

@section('title', 'Master')
@section('page', 'master')

@section('style')
    <link rel="stylesheet" href="/css/master.css">
@endsection

@section('content')
    <section class="master-header">
        <div class="bg-header">
        </div>
        <div class="header-content">
            <h1 class="header">Explore the real master...</h1>
            <div class="search-box-wrapper">
                <input class="search-box" placeholder="Search your activities..." type="text">
                <button class="button">Explore</button>
            </div>
            <div class="master-interest">
                <h2 class="header">Master you may interest</h2>
                <div class="master-list">
                    <div class="master-category">
                        <h3 class="header">Fishery master</h3>
                        <div class="master-content">
                            <div class="master-detail">
                                @component('components.master-card', ['noimage'=>true, 'animate'=>true, 'size'=>70])
                                @endcomponent
                                <div class="image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="name">Adam</div>
                                <div class="badge">Beginner most recommended</div>
                            </div>
                            <div class="master-detail">
                                @component('components.master-card', ['noimage'=>true, 'animate'=>true, 'size'=>70])
                                @endcomponent
                                <div class="image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="name">Adam</div>
                                <div class="badge">Beginner most recommended</div>
                            </div>
                        </div>
                    </div>
                    <div class="master-category">
                        <h3 class="header">Fishery master</h3>
                        <div class="master-content">
                            <div class="master-detail">
                                @component('components.master-card', ['noimage'=>true, 'animate'=>true, 'size'=>70])
                                @endcomponent
                                <div class="image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="name">Adam</div>
                                <div class="badge">Beginner most recommended</div>
                            </div>
                            <div class="master-detail right">
                                @component('components.master-card', ['noimage'=>true, 'animate'=>true, 'size'=>70])
                                @endcomponent
                                <div class="image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="name">Adam</div>
                                <div class="badge">Beginner most recommended</div>
                            </div>
                        </div>
                    </div>
                    <div class="master-category">
                        <h3 class="header">Fishery master</h3>
                        <div class="master-content">
                            <div class="master-detail right">
                                @component('components.master-card', ['noimage'=>true, 'animate'=>true, 'size'=>70])
                                @endcomponent
                                <div class="image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="name">Adam</div>
                                <div class="badge">Beginner most recommended</div>
                            </div>
                            <div class="master-detail right">
                                @component('components.master-card', ['noimage'=>true, 'animate'=>true, 'size'=> 70])
                                @endcomponent
                                <div class="image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="name">Adam</div>
                                <div class="badge">Beginner most recommended</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="master-profile-section">
        <div class="search-wrapper">
            <div class="category-name"></div>
            <div class="search-box-wrapper">
                <input class="search-box" placeholder="Search your activities..." type="text">
            </div>
        </div>
        <div class="filter-category"></div>
        <div class="master-profile-wrapper">
            <div class="master-profile">
                {{--                เอาจากหน้า activity--}}
            </div>
            <div class="master-video">
                <div class="master-action">

                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
    <script>
        $(document).ready(function () {
            var lazyLoadInstance = new LazyLoad({
                elements_selector: '.lazy',
                // ... more custom settings?
            })
        })
    </script>
@endsection
