<x-mail::message>
    @if(app()->getLocale() == 'ar')
    <div dir="rtl">
        @else
        <div dir="ltr">
            @endif
            {{ $message }}
        </div>
<x-mail::button :url="$route">
    {{ __('Explore') }}
</x-mail::button>

        {{ __('Thanks,') }}
        {{ __(config('app.name')) }}
</x-mail::message>