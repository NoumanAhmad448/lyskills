@php
$data = $prop["data"] ?? '';
$id = $prop["data"]["id"];
$en_fun = $prop["data"]["en_fun"] ?? true;
$map = "map".gen_str();
debug_logs("admin blade component");
debug_logs($data);

@endphp
@include(config("files.components_")."modal",
[
    config("vars.prop") => [
        config("vars.id") => $map
    ]
])
@include(config("files.components_")."modal",
[
    config("vars.prop") => [
        "body" => config("files.forms").config("setting.message_form")
    ]
])
@include(config("files.components_")."loader", [config("vars.prop") => [
    "id" => $id
]])
@if ($data && $data['lands'])
    @if ($data['title'])
        <h1> {{ $data['title'] }} </h1>
    @endif
    @if($en_fun && count($data['lands']) && isAdmin(false))
    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5 p-4">
        @include(config("files.forms").'three_col', ['input' =>
        config("files.forms")."dropdown",
        config("vars.prop") => [
            "id" => config("form.land_ops"),
            "include_star" => false,
            "label" => __("messages.land_op"),
            "data" => __("messages.lnd_oprtn") ,
        ]
        ]
        )
        @include(config("files.forms").'two_col', [
            'input' => config("files.forms")."submit",
            "text" => __("attributes.update"),
            "id" => config("form.update"),
            "is_btn" => "button",
            "classes" => "pt-5",
            "extra_atrr" => ["data-modal-target" => "default-modal"]
        ])
    </div>
    @endif
    <table class="display" id="{{ $id }}">
        <thead>
            <tr>
                @if(isAdmin(false))
                    <th>#</th>
                @endif
                <th>{{ __('table.' . config('table.user')) }}</th>
                <th>{{ __('table.' . config('table.title')) }}</th>
                <th>{{ __('table.' . config('table.description')) }}</th>
                <th>{{ __('table.' . config('table.location')) }}</th>
                <th>{{ __('table.' . config('table.size')) }}</th>
                <th>{{ __('table.' . config('table.city')) }}</th>
                <th>{{ __('table.' . config('table.is_admin_approved')) }}</th>
                <th>{{ __('table.' . config("table.comment")) }}</th>
                @can(config("policy.is_super_admin"))
                    <th>{{ __('table.' . config("table.land_logs")) }}</th>
                @endcan
                @can(config("policy.view_land_comment"))
                    <th>{{ __('table.' . config("table.land_comments_logs")) }}</th>
                @endcan
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
                        @if(isAdmin(false))
                            <td>
                                @include(config('files.forms') . 'checkbox', [
                                    'prop' => [
                                        'id' => config('form.land_ids'),
                                        "value" => $lands->id
                                    ],
                                ])
                            </td>
                        @endif
                        <td>{{ $lands?->user?->name }}</td>
                        <td>{{ $lands?->title }}</td>
                        <td>{{ $lands?->description }}</td>
                        <td onclick="showMap('{{$lands?->location}} {{ $lands?->city?->name }}','{{$map}}')"
                            class="underline cursor-pointer"
                            data-modal-target = "{{$map}}"
                            >
                            {{ $lands?->location }}
                        </td>
                        <td>{{ $lands?->size  }}</td>
                        <td>{{ $lands?->city?->name }}</td>
                        <td
                            @php
                                $land_approval = $lands->landComment && count($lands->landComment);
                                $is_admin_approved = false;
                                if($land_approval){
                                    $is_admin_approved = $lands->landComment[0]->is_admin_approved;
                                }
                            @endphp
                            class="text-white text-center @include(config("files.cls").'admin_approved'
                            , ["is_admin_approved" => $is_admin_approved]
                            )">
                            {{ $is_admin_approved ? __("messages.yes") : __("messages.no") }}
                        </td>
                        <td>{{ $is_admin_approved ? $lands->landComment[0]->comment : '' }}</td>
                        @can(config("policy.is_super_admin"))
                            <th>
                                <a target="_blank" class="hover:no-underline underline"
                                            href="{{ route("land_logs",
                                            [config("table.primary_key") => $lands->id]) }}">
                                            {{ __("table.land_logs") }}
                                </a>
                            </th>
                        @endcan
                        @can(config("policy.view_land_comment"))
                        <th>
                            <a target="_blank" class="hover:no-underline underline"
                                        href="{{ route("comment_logs",
                                        [config("table.primary_key") => $lands->id]) }}">
                                        {{ __("table.land_comments_logs") }}
                            </a>
                        </th>
                        @endcan
                        <td>{{ $is_admin_approved && $lands->landComment[0]->user
                                ? $lands?->landComment[0]?->user?->name : '' }}
                        </td>
                        @if (config('setting.en_slf'))
                            <td>
                                @if (count($lands->landFiles) > 0)
                                    @foreach ($lands->landFiles as $landFile)
                                        <a target="_blank" class="no-underline hover:underline"
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
            @include(config("files.components_")."loader_script", [config("vars.prop") =>
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
    let map = '{{ $map }}';

    debug_logs(land_ids);
    debug_logs("lands_ids => ".lands_ids);
    debug_logs(update_field);
    debug_logs(land_ops);
    debug_logs(land_ops_id);
    debug_logs(map);
</script>
<script src="{{ mix(config('setting.admin_lands_js')) }}"></script>
@endif

