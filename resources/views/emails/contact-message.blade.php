@extends('emails.layout')

@section('content')

<h1 style="
    margin: 0 0 30px 0;
    color: #eeeeee;
    font-size: 28px;
    line-height: 34px;
">
    New contact message
</h1>

<p style="
    margin: 0 0 12px 0;
    color: #cccccc;
    font-size: 16px;
    line-height: 24px;
">
    <strong style="color: #eeeeee;">Name:</strong>
    {{ $contact['name'] }}
</p>

<p style="
    margin: 0 0 30px 0;
    color: #cccccc;
    font-size: 16px;
    line-height: 24px;
">
    <strong style="color: #eeeeee;">Email:</strong>
    <a
        href="mailto:{{ $contact['email'] }}"
        style="color: #6c6eec; text-decoration: none;"
    >
        {{ $contact['email'] }}
    </a>
</p>

<table
    role="presentation"
    cellpadding="0"
    cellspacing="0"
    border="0"
    width="100%"
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

@endsection
