<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">

    <title>{{ $title ?? 'Ωmega' }}</title>

    <style>
        :root {
            color-scheme: light dark;
        }
        body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            background-color: #f5f5f5;
            color: #222222;
        }
        .email-background {
            background-color: #f5f5f5 !important;
        }
        .email-container {
            background-color: #ffffff !important;
            border-color: #dddddd !important;
        }
        .email-heading {
            color: #222222 !important;
        }
        .email-text {
            color: #444444 !important;
        }
        .email-muted {
            color: #666666 !important;
        }
        .email-message {
            background-color: #f5f5f5 !important;
            border-color: #6c6eec !important;
            color: #444444 !important;
        }
        .email-link {
            color: #6c6eec !important;
        }
        .email-separator {
            border-color: #6c6eec !important;
        }

        @media (prefers-color-scheme: dark) {
            body {
                background-color: #111111 !important;
                color: #eeeeee !important;
            }
            .email-background {
                background-color: #111111 !important;
            }
            .email-container {
                background-color: #222222 !important;
                border-color: #444444 !important;
            }
            .email-heading {
                color: #eeeeee !important;
            }
            .email-text {
                color: #cccccc !important;
            }
            .email-muted {
                color: #aaaaaa !important;
            }
            .email-message {
                background-color: #111111 !important;
                border-color: #6c6eec !important;
                color: #cccccc !important;
            }
            .email-link {
                color: #6c6eec !important;
            }
            .email-separator {
                border-color: #444444 !important;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0; width: 100%; background-color: #f5f5f5; color: #222222;">
    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" class="email-background" style="width: 100%; background-color: #f5f5f5;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" class="email-container" style="width: 100%; max-width: 640px; background-color: #ffffff; border: 1px solid #dddddd;">
                    <tr>
                        <td style="padding: 40px;">
                            <img src="https://ome.gs/vector/omega.svg" alt="Omega" width="180" style="display: block; width: 180px; height: auto; border: 0; margin: 0 0 30px 0;">

                            @yield('content')
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
