@extends('emails.layout')

@section('content')

<h1 style="
    margin: 0 0 24px 0;
    color: #eeeeee;
    font-size: 28px;
    line-height: 34px;
">
    Thanks for getting in touch, {{ $contact['name'] }}!
</h1>

<p style="
    margin: 0 0 20px 0;
    color: #cccccc;
    font-size: 16px;
    line-height: 26px;
">
    I've received your message and will get back to you as soon as I can.
</p>

<p style="
    margin: 0 0 10px 0;
    color: #cccccc;
    font-size: 16px;
    line-height: 26px;
">
    Your message was:
</p>

<table
    role="presentation"
    cellpadding="0"
    cellspacing="0"
    border="0"
    width="100%"
    style="margin: 0 0 20px 0;"
>
    <tr>
        <td style="
            padding: 20px;
            border-left: 3px solid #6c6eec;
            background-color: #111111;
            color: #cccccc;
            font-size: 15px;
            line-height: 24px;
        ">
            {!! nl2br(e($contact['message'])) !!}
        </td>
    </tr>
</table>

<p style="
    margin: 0;
    color: #cccccc;
    font-size: 16px;
    line-height: 26px;
">
    Cheers,<br>
    Sander
</p>

@include('emails.partials.signature')

@endsection
