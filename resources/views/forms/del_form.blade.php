<form id="del_form" enctype="multipart/form-data">
    @include(config("files.components_").'csrf')
    @include(config("files.components_").'form_type', ["method" => "DELETE"])

    @include(config("files.forms").'field',[
        "prop" => [
            "type" => "hidden", "id" => config("table.primary_key"),
    ]])
</form>