@extends('dev.dev_main')
{{ debug_logs($cron_jobs) }}

@section('content')
    <div class="table-responsive mt-2">
        <table class="table table-hover table-striped">
            <thead>
            </thead>
            <tbody>
                @if ($cron_jobs->count())
                    <div class="d-flex justify-content-end">
                        <a href="" class="btn btn-lg btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            Create Cron Job
                        </a>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Mark</th>
                                    <th scope="col"> Name </th>
                                    <th scope="col"> Email </th>
                                    <th scope="col"> Status </th>
                                    <th scope="col"> Title </th>
                                    <th scope="col"> Starts At</th>
                                    <th scope="col"> Ends At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cron_jobs as $cron_job)
                                    <tr>
                                        @php $status = $cron_job->status; @endphp
                                        <td>
                                            <form action="" method="post">
                                                @csrf
                                                <input type="checkbox" name="status" class="change_status"
                                                    @if ($status === 'published') checked @endif />
                                            </form>
                                        </td>
                                        <td> {{ $cron_job->name }}</td>
                                        <td> {{ $cron_job->email }} </td>
                                        <td>
                                            <div
                                                class="badge @if ($status == 'unpublished') badge-danger @else badge-success @endif  rounded">
                                                {{ $status }}
                                            </div>
                                        </td>
                                        <td> {{ $cron_job->title }}</td>
                                        <td> {{ $cron_job->starts_at }}</td>
                                        <td> {{ $cron_job->ends_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                @endif
        </table>
    @endsection
