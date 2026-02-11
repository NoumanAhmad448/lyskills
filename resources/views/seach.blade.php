@if (config('setting.guest_search_bar'))
    <div class="col-md-6">
        <form action="{{ route('c-search-page') }}" method="post">
            <div class="searchbar mt-4 mt-md-0">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input class="search_input" type="text" name="search_course" id="search_course"
                    placeholder="Search Your Favorite Course...">
                <button type="submit" class="search_icon btn"><i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </div>
        </form>
    </div>
@endif
