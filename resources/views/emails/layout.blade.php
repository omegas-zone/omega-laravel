<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Ωmega' }}</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #111111;
    color: #eeeeee;
    font-family: Arial, Helvetica, sans-serif;
">

<table
    role="presentation"
    cellpadding="0"
    cellspacing="0"
    border="0"
    width="100%"
    style="background-color: #111111;"
>
    <tr>
        <td align="center" style="padding: 40px 20px;">

            <table
                role="presentation"
                cellpadding="0"
                cellspacing="0"
                border="0"
                width="100%"
                style="
                    max-width: 640px;
                    background-color: #222222;
                    border: 1px solid #444444;
                "
            >
                <tr>
                    <td style="padding: 40px;">
                        @yield('content')
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>

</body>
</html>
