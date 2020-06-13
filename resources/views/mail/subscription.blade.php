@component('mail::message')
Thanks for becoming a Pro Customer, {{ $license->customer->first_name }}

Please copy the license key below and save it in Auto Share plugin Settings area:

{{-- {{
    $event->license;
}}
This is key is valid until {{ $event->license->expiry_date }} --}}

User you can login to manage your subscription using:

    Email: {{ $license->customer->user->email }}
    Password: {{ $license->customer->user->password }}

To login please go to:
@component('mail::button', ['url' => '/login'])
    Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
