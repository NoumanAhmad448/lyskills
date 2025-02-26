@php
$data = $prop["data"] ?? '';
$id = $prop["data"]["id"];
$en_fun = $prop["data"]["en_fun"] ?? true;

debug_logs("admin blade component");
debug_logs($data);

@endphp


@if ($data && $data['lands'])
    @if ($data['title'])
        <h1> {{ $data['title'] }} </h1>
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
                        <td>{{ $lands?->user?->name}}</td>
                        <td>{{ $lands->title ?? '' }}</td>
                        <td>{{ $lands->description ?? '' }}</td>
                        <td>{{ $lands->location ?? '' }}</td>
                        <td>{{ $lands->size ?? '' }}</td>
                        <td>{{ $lands->city && $lands->city->name ? $lands->city->name : '' }}</td>

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

