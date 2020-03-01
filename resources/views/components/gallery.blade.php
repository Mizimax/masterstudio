@if(count($galleries) === 0)
    <div align="center">No gallery picture now.</div>
@else
    <div class="gallery-flex --first">
        @for($i = 0; $i < count($galleries); $i+=2)
            <div class="image-container {{ $me ? 'me' : '' }}"
                 tabindex="-1">
                <img src="{{ $galleries[$i] }}"
                     class="image">
                @if($me)
                    <button class="delete-btn"
                            onclick="deletePicGallery({{ count($galleries)-$i-1 }})"></button>
                @endif
            </div>
        @endfor
    </div>
    <div class="gallery-flex --second">
        @for($i = 1; $i < count($galleries); $i+=2)
            <div class="image-container {{ $me ? 'me' : '' }}"
                 tabindex="-1">
                <img src="{{ $galleries[$i] }}"
                     class="image">
                @if($me)
                    <button class="delete-btn"
                            onclick="deletePicGallery({{ count($galleries)-$i-1 }})"></button>
                @endif
            </div>
        @endfor
    </div>
@endif