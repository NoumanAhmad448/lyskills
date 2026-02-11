<ul class="nav nav-pills" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#public" role="tab" aria-controls="public"
            aria-selected="true">Public Announcement</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="public" role="tabpanel" aria-labelledby="home-tab">
        @if ($c_anns->count())
            <h2 class="text-center"> Announcements </h2>
            @foreach ($c_anns as $ann)
                <section class="border p-3 mt-3">
                    <h3>
                        {{ $ann->subject ?? '' }}
                    </h3>
                    <div>
                        {{ $ann->body ?? '' }}
                    </div>
                </section>
            @endforeach
        @else
            <div class="ml-3 mt-2"> No Announcement was made yet </div>
        @endif

    </div>
</div>
