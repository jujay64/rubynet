@component('mail::message')
# Hello {{$user->first_name}} {{$user->last_name}}

Thank you for creating an account. Please verify your email using this button :

@component('mail::button', ['url' => route('user.verify', $user->verification_token)])
Verify Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
