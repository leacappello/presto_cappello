<form
    action="{{ route('setLocale', $lang) }}"
    method="POST"
    class="d-inline"
>
    @csrf

    <button type="submit" class="btn border-0 p-1">
        <img
            src="{{ asset('vendor/blade-flags/country-' . $lang . '.svg') }}"
            alt="{{ $lang }}"
            width="28"
            height="28"
        >
    </button>
</form>