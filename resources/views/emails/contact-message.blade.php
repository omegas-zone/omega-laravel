@extends('emails.layout')

@section('content')

<h1 class="email-heading" style="margin: 0 0 30px 0; color: #222222; font-family: 'Afacad', Arial, Helvetica, sans-serif; font-size: 32px; line-height: 40px;">
    New contact message
</h1>

<p class="email-text" style="margin: 0 0 12px 0; color: #444444; font-family: 'Afacad', Arial, Helvetica, sans-serif; font-size: 20px; line-height: 28px;">
    <strong class="email-heading" style="color: #222222;">Name:</strong> {{ $contact['name'] }}
</p>

<p class="email-text" style="margin: 0 0 30px 0; color: #444444; font-family: 'Afacad', Arial, Helvetica, sans-serif; font-size: 20px; line-height: 28px;">
    <strong class="email-heading" style="color: #222222;">Email:</strong> <a href="mailto:{{ $contact['email'] }}" class="email-link" style="color: #6c6eec; text-decoration: none;">{{ $contact['email'] }}</a>
</p>

<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin: 0;">
    <tr>
        <td class="email-message" style="padding: 20px; border-left: 3px solid #6c6eec; background-color: #f5f5f5; color: #444444; font-family: 'Afacad', Arial, Helvetica, sans-serif; font-size: 20px; line-height: 28px;">
            {!! nl2br(e($contact['message'])) !!}
        </td>
    </tr>
</table>

@endsection
