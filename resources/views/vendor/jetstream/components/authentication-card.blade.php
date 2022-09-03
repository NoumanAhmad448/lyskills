{{-- <div class="d-flex flex-column justify-sm-content-center flex flex-col sm:justify-center items-center pt-3 sm:pt-0 my-4"> --}}
<div class="d-flex flex-column justify-sm-content-center align-items-center pt-3 pt-sm-0 my-4 col-md-8 offset-md-2">
    <div class="d-flex justify-content-center">
        {{ $logo }}
    </div>

    {{-- <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white overflow-hidden sm:rounded-lg"> --}}
    <div class="mt-6 px-6 py-4 bg-white overflow-hidden rounded d-block">
        {{ $slot }}
    </div>
</div>
