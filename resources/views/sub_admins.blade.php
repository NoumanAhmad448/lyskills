@php
$data = $prop["data"] ?? '';
$id = $prop["data"]["id"];
$en_fun = $prop["data"]["en_fun"] ?? true;

debug_logs("subadmin blade component");
debug_logs($data);


@endphp
@include(config("files.components_")."modal",
[
    "prop" => [
        "id" => config("setting.crtr_admn_mdl"),
        "body" => config("files.forms")."user_reg_form"
    ]
])
@if ($data && $data[config("keys.users")])

    @include(config("files.components_")."modal",
    [
        "prop" => [
            "body" => config("files.forms").config("setting.update_password")
        ]
    ])
    @include(config("files.forms")."del_form")
@endif
@include(config("files.components_")."loader", ["prop" => [
    "id" => $id
]])
@if ($data && $data[config("keys.users")])
    @if ($data[config("keys.title")])
        <h1> {{ $data[config("keys.title")] }} </h1>
    @endif
    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-9 p-4">
    @if($en_fun && count($data[config("keys.users")]))
        @include(config("files.forms").'five_col', ['input' =>
            config("files.forms")."dropdown",
            "prop" => [
                "id" => config("form.admn_op"),
                "include_star" => false,
                "label" => __("messages.admn_op"),
                "data" => __("messages.adm_oprtn") ,
            ]
            ]
        )
        @include(config("files.forms").'col', [
            'col' => 2,
            'input' => config("files.forms")."submit",
            "text" => __("attributes.update"),
            "id" => config("form.update"),
            "is_btn" => "button",
            "classes" => "pt-5",
            "extra_atrr" => ["data-modal-target" => "default-modal"]
        ])
    @endif
        @include(config("files.forms").'two_col', [
            'input' => config("files.forms")."submit",
            "text" => __("attributes.crte_admn"),
            "id" => config("form.crte_admn"),
            "is_btn" => "button",
            "classes" => "pt-5",
            "extra_atrr" => ["data-modal-target" => config("setting.crtr_admn_mdl")]
        ])
    </div>

    <table class="display" id="dt{{ $id }}">
        <thead>
            <tr>
                @if(isAdmin(false))
                    <th>#</th>
                @endif
                <th>{{ __('table.' . config('table.name')) }}</th>
                <th>{{ __('table.' . config('form.email')) }}</th>
                <th>{{ __('table.' . config('table.is_active')) }}</th>
                <th>{{ __('table.' . config('table.created_at')) }}</th>
                <th>{{ __('table.' . config('table.updated_at')) }}</th>
            </tr>
        </thead>
        <tbody class="hidden" id="{{$id}}tbody">
            @if (count($data[config("keys.users")]) > 0)
                @foreach ($data[config("keys.users")] as $user)
                    <tr>
                        @if(isAdmin(false))
                            <td>
                                @include(config('files.forms') . 'checkbox', [
                                    'prop' => [
                                        'id' => "d".config('form.primary_key'),
                                        "value" => $user->id
                                    ],
                                ])
                            </td>
                        @endif
                        <td>{{ $user?->name ?? 'no name' }}</td>
                        <td>{{ $user?->email ?? '' }}</td>
                        <td class="text-center @include(config("files.cls").'deleted'
                            , ["deleted_at" => $user?->deleted_at]
                            )" >
                            {{ $user->deleted_at ? __("messages.no") : __("messages.yes") }}</td>
                        <td>{{ $user->created_at ?? '' }}</td>
                        <td>{{ $user->updated_at ?? '' }}</td>
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
    let user_ids = "d{{ config('form.primary_key') }}";
    let users_ids = '{{ config("table.primary_key") }}';
    let update_field = "{{ config('form.update') }}";
    let admn_op = '{{ config("form.admn_op") }}';
    let admn_op_id = '{{ config("table.admn_op_id") }}';
    let del_form = '{{ config("setting.del_form") }}';
    let update_form = '{{ config("setting.update_password") }}';
    let user_update = '{{ route("updt_create_admin") }}';
    let user_del = '{{ route("del_create_admin") }}';
    let crte_admn = '{{ config("form.crte_admn") }}';
    IselExist(`#${crte_admn}`)
    let user_reg = "{{ config('setting.user_reg') }}";
    IselExist(`#${user_reg}`)
    let crtr_admn_mdl = '{{ config("setting.crtr_admn_mdl") }}';
    let crte_admin_url = '{{ route("crte_admin") }}';
    debug_logs("crte_admin_url => ".crte_admin_url);

    debug_logs("user_ids => ".user_ids);
    debug_logs("users_ids => ".users_ids);
    debug_logs(update_field);
    debug_logs(admn_op);
    debug_logs(admn_op_id);
</script>
<script>
    let table{{$id}} = dataTable('dt{{ $id }}',{
         order : {
            col_no : 1
        }
    });
</script>
<script src="{{ mix(config('setting.sub_admins_js')) }}"></script>
@endif

