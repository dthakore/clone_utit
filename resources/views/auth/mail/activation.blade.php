@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img src="{{ asset('img/eazybot-logo.svg') }}" alt="logo" width="200px"/>
@endcomponent
@endslot

{{-- Body --}}
<b>Dear {{ $data['name'] }}</b>
<p>You now have access to the restricted part of the {{ config('app.name') }} website. Please be aware that this content is only intented for people who have been introduced to the opportunity and have already received ample information about the investment opportunity.</p>
<p>If this is the case, please <a style='text-decoration: none;' href='{{ $data['url'] }}'>click here</a></p>

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
