@extends('dev.dev_main')

@section('content')
    <button class="delete-files-btn btn btn-primary" data-url="{{ route('deleteProjectDelete') }}" data-path="/"
        onclick="confirmDelete(this)">
        Delete Files
    </button>
@endsection

@section('page-js')
    <script type="text/javascript">
        function confirmDelete(btn) {
            let url = btn.getAttribute("data-url");
            let path = btn.getAttribute("data-path");

            if (confirm("Are you sure you want to delete the files? This action is irreversible.")) {
                if (confirm("This is your final confirmation. Do you really want to proceed?")) {
                    sendDeleteRequest(url, path);
                }
            }
        }

        function sendDeleteRequest(url, path) {
            $.ajax({
                url: url,
                type: 'POST',
                data: JSON.stringify({
                    path: path,
                    _method: 'DELETE'
                }),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    showResponse(response);
                },
                error: function(xhr) {
                    let errorMsg = "An error occurred while deleting files.";
                    if (xhr.responseText) {
                        let errResponse = JSON.parse(xhr.responseText);
                        if (errResponse.error) {
                            errorMsg = errResponse.error;
                        }
                    }
                    showResponse({
                        message: errorMsg,
                        failed_deletes: []
                    });
                }
            });
        }

        function showResponse(response) {
            let message = response.message || "Deletion completed.";
            let failedFiles = response.failed_deletes || [];

            let show_messageMsg = message;
            if (failedFiles.length > 0) {
                show_messageMsg += "\n\nThe following files could not be deleted:\n" + failedFiles.join("\n");
            }

            show_message(show_messageMsg);
        }
    </script>
@endsection
