<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (file_exists(asset(config('setting.img_logo_path'))))
                <img src="{{ asset(config('setting.img_logo_path')) }}" class="logo" alt="Lyskills Logo">
            @else
                {{ config('app.name') }}
            @endif
        </a>
    </td>
</tr>
