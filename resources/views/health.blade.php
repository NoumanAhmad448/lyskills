@extends('admin.admin_main')
@section('page-css')
@endsection
@section('content')
@php
$constant = "test";
@endphp
<body class="antialiased bg-gray-100 mt-7 md:mt-12 dark:bg-gray-900">
    <div class="mx-auto max-w-7xl lg:px-8 sm:px-6">
        <div class="flex flex-wrap justify-center space-y-3">
            <h4 class="w-full text-2xl font-bold text-center text-gray-900 dark:text-white">{{ __('health::notifications.laravel_health') }}</h4>
            <div class="flex justify-center w-full">
                <x-health-logo/>
            </div>

            @if ($lastRanAt)
                <div id="{{$constant}}notifications" class="hidden {{ $lastRanAt->diffInMinutes() > 5 ? 'text-red-400' : 'text-gray-400 dark:text-gray-500' }} text-sm text-center font-medium">
                    {{ __('health::notifications.check_results_from') }} {{ $lastRanAt->diffForHumans() }}
                </div>
                

            @endif

        </div>
        <div class="px-2 my-6 md:mt-8 md:px-0 container">
            @if (count($checkResults?->storedCheckResults ?? []))
                <dl class="row grid grid-cols-1 gap-2.5 sm:gap-3 md:gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($checkResults->storedCheckResults as $key => $result)
                        @include(config("files.components_")."loader", ["prop" => [
                            "id" => "{$constant}{$key}"
                        ]])
                        <div id="{{$constant}}{{$key}}{{$constant}}" class="col-3 hidden flex items-start px-4 space-x-2 overflow-hidden py-5 text-opacity-0 transition transform bg-white shadow-md shadow-gray-200 dark:shadow-black/25 dark:shadow-md dark:bg-gray-800 rounded-xl sm:p-6 md:space-x-3 md:min-h-[130px] dark:border-t dark:border-gray-700">
                            <!-- <x-health-status-indicator :result="$result" /> -->
                            <div>
                                <dd class="-mt-1 font-bold text-gray-900 dark:text-white md:mt-1 md:text-xl">
                                    {{ $result->label }}
                                </dd>
                                <dt class="mt-0 text-sm font-medium text-gray-600 dark:text-gray-300 md:mt-1">
                                    @if (!empty($result->notificationMessage))
                                        {{ $result->notificationMessage }}
                                    @else
                                        {{ $result->shortSummary }}
                                    @endif
                                </dt>
                            </div>
                        </div>
                        @include(config("files.components_")."loader_script", ["prop" => [
                        'id' => "{$constant}{$key}",
                        "hide_el" => "{$constant}{$key}{$constant}"]])
                    @endforeach
                </dl>
            @endif
        </div>
    </div>
</body>
</html>
@endsection
@section('script')
@endsection