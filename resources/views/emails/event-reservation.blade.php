@component('mail::message')
# Jambo,

{{$data['message']}}

@component('mail::button', ['url' => 'https://vinnjeru.com'])
Visit Site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
