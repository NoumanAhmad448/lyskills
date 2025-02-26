@php
$data = $prop["data"] ?? '';
$id = $prop["data"]["id"];
$en_fun = $prop["data"]["en_fun"] ?? true;

debug_logs("comment logs blade component");
debug_logs($data);

@endphp


@if ($data && $data[config("table.land_comments_logs")])
    @if ($data['title'])
        <h1> {{ $data['title'] }} </h1>
    @endif

    <table class="display" id="{{ $id }}">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('table.' . config('table.comment')) }}</th>
                <th>{{ __('table.' . config('table.is_admin_approved')) }}</th>
                <th>{{ __('table.' . config('table.created_by')) }}</th>
                <th>{{ __('table.' . config('table.created_at')) }}</th>
                <th>{{ __('table.' . config('table.updated_at')) }}</th>
            </tr>
        </thead>
        <tbody class="hidden" id="{{$id}}tbody">
            @if (count($data[config("table.land_comments_logs")]) > 0)
                @foreach ($data[config("table.land_comments_logs")] as $comment)
                    <tr>
                        <td>
                            @include(config('files.forms') . 'checkbox', [
                                'prop' => [
                                    'id' => config('form.land_ids'),
                                    "value" => $comment->id
                                ],
                            ])
                        </td>
                        <td>{{ $comment?->comment }}</td>
                        <td class="
                            @include(config("files.cls").'admin_approved',
                                        [
                                        "is_admin_approved" => $comment?->is_admin_approved
                                        ]
                            )">
                            {{ $comment?->is_admin_approved ? __("messages.yes") : __("messages.no") }}</td>
                        <td>{{ $comment?->user?->name  }}</td>

                        <td>{{ $comment?->created_at  }}</td>
                        <td>{{ $comment?->updated_at  }}</td>
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
    let table{{$id}} = dataTable('{{ $id }}',{
         order : {
            col_no : 3
        }
    }
    );
</script>
@endif

