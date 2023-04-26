<div>
    {{-- Success is as dangerous as failure. --}}
    <form class="comment-form comment-form-chat" wire:submit.prevent="store">
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <input type="text" placeholder="Add a comment..." wire:model="newComment" name="newComment">
        
        <button type="submit" class="ms-1">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="25.000000pt" height="25.000000pt" viewBox="0 0 30.000000 30.000000" preserveAspectRatio="xMidYMid meet" class="SendSVG">
                <g transform="translate(0.000000,30.000000) scale(0.100000,-0.100000)" fill="#119fff8f" stroke="none">
                    <path d="M44 256 c-3 -8 -4 -29 -2 -48 3 -31 5 -33 56 -42 28 -5 52 -13 52 -16 0 -3 -24 -11 -52 -16 -52 -9 -53 -9 -56 -48 -2 -21 1 -43 6 -48 10 -10 232 97 232 112 0 7 -211 120 -224 120 -4 0 -9 -6 -12 -14z"></path>
                </g>
            </svg>
        </button>
    </form>
</div>
