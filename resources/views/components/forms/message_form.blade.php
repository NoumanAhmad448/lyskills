<form id="message_form" enctype="multipart/form-data">
    @include(config("files.components_").'csrf')
    @include(config("files.components_").'form_type')
    @include(config("files.components_")."textarea",
    [
        "prop" => ["placeholder" => __("messages.land_msg_txtarea")],
        "id" => config("table.comment")

    ])
    @include(config("files.forms").'field',[
        "prop" => [
            "type" => "hidden", "id" => config("table.land_create_id"),
    ]])
    @include(config("files.forms").'field',[
        "prop" => [
            "type" => "hidden", "id" => config("table.land_ops_id"),
    ]])
   @include(config('files.forms').'col', [
        'input' => config('files.forms') . 'submit',
        'move_btn_right' => true,
        "id" => config("form.submit"),
        "text" => __("messages.SubmitButton"),
        "classes" => "mt-5"
    ])
</form>