@php
$user_id = $user_id ?? "";
@endphp
<form id="update_password" enctype="multipart/form-data">
    @include(config("files.components_").'csrf')
    @include(config("files.components_").'form_type')
    @include(config("files.forms").'three_col', ['input' => config("files.forms").'password'])
    @include(config("files.forms").'field',[
        "prop" => [
            config("vars.type") => "hidden",
            config("vars.id") => config("table.primary_key"),
            config("vars.value") => "$user_id",
    ]])
   @include(config('files.forms').'col', [
        'input' => config('files.forms') . 'submit',
        'move_btn_right' => true,
        "id" => config("form.submit"),
        "text" => __("messages.update_pass"),
        "classes" => "mt-5"
    ])
</form>