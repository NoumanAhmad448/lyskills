@extends('dev.dev_main')

@section('content')
    <div class="container">
        <h1>Monitored Scheduled Tasks</h1>
        <table class="table table-bordered" id="example">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Cron Expression</th>
                    <th>Timezone</th>
                    <th>Ping URL</th>
                    <th>Last Started At</th>
                    <th>Last Finished At</th>
                    <th>Last Skipped At</th>
                    <th>Last Failed At</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->type }}</td>
                        <td>{{ $task->cron_expression }}</td>
                        <td>{{ $task->timezone }}</td>
                        <td>{{ $task->ping_url }}</td>
                        <td>{{ $task->last_started_at }}</td>
                        <td>{{ $task->last_finished_at }}</td>
                        <td>{{ $task->last_skipped_at }}</td>
                        <td>{{ $task->last_failed_at }}</td>
                        <td>{{ $task->created_at }}</td>
                        <td>{{ $task->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script>
        $('#example').DataTable({
            language: {
                searchPlaceholder: "Search records"
            }
        });
    </script>
@endsection
