@php
$data = $prop["data"] ?? '';
$id = $prop["data"]["id"];
$en_fun = $prop["data"]["en_fun"] ?? true;

debug_logs("admin blade component");
debug_logs($data);

@endphp
@include(config("files.components_")."modal",
[
    "prop" => [
        "body" => config("files.forms").config("setting.message_form")
    ]
])
@include(config("files.components_")."loader", ["prop" => [
    "id" => $id
]])
@if ($data && $data['lands'])
    @if ($data['title'])
        <h1> {{ $data['title'] }} </h1>
    @endif
    <table class="display" id="{{ $id }}">
        <thead>
            <tr>
                <th>{{ __('table.' . config('table.user')) }}</th>
                <th>{{ __('table.' . config('table.title')) }}</th>
                <th>{{ __('table.' . config('table.description')) }}</th>
                <th>{{ __('table.' . config('table.location')) }}</th>
                <th>{{ __('table.' . config('table.size')) }}</th>
                <th>{{ __('table.' . config('table.city')) }}</th>
                <th>{{ __('table.' . config('table.is_admin_approved')) }}</th>
                <th>{{ __('table.' . config("table.comment")) }}</th>
                <th>{{ __('table.' . config("table.created_by")) }}</th>
                @if (config('setting.en_slf'))
                    <th>{{ __('table.' . config('table.land_files')) }}</th>
                @endif
                <th>{{ __('table.' . config('table.created_at')) }}</th>
                <th>{{ __('table.' . config('table.updated_at')) }}</th>
            </tr>
        </thead>
        <tbody class="hidden" id="{{$id}}tbody">
            @if (count($data['lands']) > 0)
                @foreach ($data['lands'] as $lands)
                    <tr>
                        <td>{{ $lands?->user?->name }}</td>
                        <td>
                            <a class="underline" href="@if(config('setting.en_lnd_edt')){{route("land_updateshow",
                                ["land" => $lands?->uuid ?? $lands ?->id ])
                             }}@endif"
                             target="_blank">
                             {{ $lands?->title }}
                             </a>
                        </td>
                        <td>{{ $lands?->description }}</td>
                        <td>{{ $lands->location ?? '' }}</td>
                        <td>{{ $lands->size ?? '' }}</td>
                        <td>{{ $lands->city && $lands->city->name ? $lands->city->name : '' }}</td>
                        <td
                            @php
                                $land_approval = $lands->landComment && count($lands->landComment);
                                $is_admin_approved = false;
                                if($land_approval){
                                    $is_admin_approved = $lands->landComment[0]->is_admin_approved;
                                }
                            @endphp
                            class="text-white text-center @if ($is_admin_approved) {{ 'bg-blue-500' }} @else {{ 'bg-red-500' }} @endif">
                            {{ $is_admin_approved ? __("messages.yes") : __("messages.no") }}
                        </td>
                        <td>{{ $is_admin_approved ? $lands->landComment[0]->comment : '' }}</td>
                        <td>{{ $is_admin_approved && $lands->landComment[0]->user
                                ? $lands->landComment[0]->user->name : '' }}
                        </td>
                        @if (config('setting.en_slf'))
                            <td>
                                @if (count($lands->landFiles) > 0)
                                    @foreach ($lands->landFiles as $landFile)
                                        <a target="_blank" class="hover:no-underline underline"
                                            href="{{ file_path($landFile->link) }}">{{ $landFile->f_name }}</a>
                                        <br /><br />
                                    @endforeach
                                @endif
                            </td>
                        @endif
                        <td>{{ $lands->created_at ? $lands->created_at : '' }}</td>
                        <td>{{ $lands->updated_at ? $lands->updated_at : '' }}</td>
                    </tr>
                @endforeach
            @endif
            @include(config("files.components_")."loader_script", ["prop" =>
            [
                'id' => $id,
                "hide_el" => "{$id}tbody"
            ]
            ])
        </tbody>
    </table>
@endif
@if($en_fun)
<script>
    let land_ids = "{{ config('form.land_ids') }}";
    let lands_ids = '{{ config("table.land_create_id") }}';
    let update_field = "{{ config('form.update') }}";
    let land_ops = "{{ config('form.land_ops') }}";
    let land_ops_id = '{{ config("table.land_ops_id") }}';
    let message_form = '{{ config("setting.message_form") }}';
    let land_update = '{{ route("land_update_blk") }}';

    debug_logs(land_ids);
    debug_logs("lands_ids => ".lands_ids);
    debug_logs(update_field);
    debug_logs(land_ops);
    debug_logs(land_ops_id);
</script>
<script src="{{ mix(config('setting.admin_lands_js')) }}"></script>
@endif

