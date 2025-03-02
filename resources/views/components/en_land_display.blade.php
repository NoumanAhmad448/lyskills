@if (config('setting.en_land_display'))
    <button
        class="bg-blue-500 rounded-2xl hover:bg-blue-700 text-white font-semibold py-2 px-4 border
                 border-gray-400 shadow">
        <a href="{{ route('land_create') }}">{{__("messages.reg_land") }}</a>
    </button>
@endif
