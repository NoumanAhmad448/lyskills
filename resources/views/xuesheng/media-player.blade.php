    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vidstack/styles/defaults.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vidstack/styles/community-skin/video.min.css" />
    <script type="module" src="https://cdn.jsdelivr.net/npm/vidstack/dist/cdn/prod.js"></script>

    {{-- prettier-ignore --}}

                <!--
    it requires three libraries to be imported.
    two of them are css files and one is js file
    all of them mentioned above in @page-css
    -->
    {{-- prettier-ignore-end --}}

    <media-player
        src="@if (file_exists(public_path('storage/' . $media->lec_name))) {{ asset('storage/' . $media->lec_name) }}@else{{ config('setting.s3Url') }}{{ $media->lec_name }} @endif"
        aspect-ratio="16/9" type="{{ $media->f_mimetype ?? '' }}"
        @if (empty($media->is_download)) {!! 'oncontextmenu="return false"' !!} @endif>
        <media-outlet>
            <media-seek-button seconds="+30">
                <media-tooltip position="top center">
                    <span>Seek +30s</span>
                </media-tooltip>
            </media-seek-button>
            <media-seek-button seconds="-30">
                <media-tooltip position="top center">
                    <span>Seek -30s</span>
                </media-tooltip>
            </media-seek-button>
        </media-outlet>
        <media-community-skin></media-community-skin>
    </media-player>
