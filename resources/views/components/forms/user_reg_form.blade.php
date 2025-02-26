<form id="{{ config('setting.user_reg') }}" enctype="multipart/form-data">
    @include(config('files.components') . '.csrf')
    @include(config('files.components_') . 'register_user')
    @include(config("files.forms").'field',[
        "prop" => [
            "type" => "hidden", "id" => config("table.is_admin"),
            "value" => 1,
    ]])
    @include(config('files.forms') . 'col', [
        'input' => config('files.forms') . 'submit',
        'move_btn_right' => true,
        'id' => 'submit',
        'text' => __('messages.usr_reg'),
    ])
</form>
