@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => 'http://localhost:4200/email/verified'])
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
