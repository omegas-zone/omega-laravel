<table
    role="presentation"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="border-collapse: collapse;"
>
    {{-- Omega logo --}}
    <tr>
        <td style="padding: 0 0 16px 0;">
            <img
                src="{{ config('app.url') }}/images/email/omega.png"
                alt="Omega"
                width="180"
                style="
                    display: block;
                    width: 180px;
                    height: auto;
                    border: 0;
                "
            >
        </td>
    </tr>

    {{-- Name --}}
    <tr>
        <td style="
            padding: 0 0 4px 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            line-height: 22px;
            color: #eeeeee;
        ">
            <strong>Sander Hartman</strong>
        </td>
    </tr>

    {{-- Website --}}
    <tr>
        <td style="
            padding: 0 0 16px 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            line-height: 20px;
        ">
            <a
                href="https://ome.gs"
                style="
                    color: #6c6eec;
                    text-decoration: none;
                "
            >
                https://ome.gs
            </a>
        </td>
    </tr>

    {{-- Separator --}}
    <tr>
        <td style="
            padding: 0 0 16px 0;
            border-bottom: 1px solid #444444;
        ">
        </td>
    </tr>

    {{-- Social links --}}
    <tr>
        <td style="padding: 16px 0 0 0;">

            <table
                role="presentation"
                cellpadding="0"
                cellspacing="0"
                border="0"
                style="border-collapse: collapse;"
            >
                <tr>

                    {{-- YouTube --}}
                    <td style="padding: 0 12px 0 0;">
                        <a
                            href="https://www.youtube.com/@omega-h8u"
                            title="YouTube"
                        >
                            <img
                                src="{{ config('app.url') }}/images/email/youtube.png"
                                alt="YouTube"
                                width="20"
                                height="20"
                                style="
                                    display: block;
                                    width: 20px;
                                    height: 20px;
                                    border: 0;
                                "
                            >
                        </a>
                    </td>

                    {{-- LinkedIn --}}
                    <td style="padding: 0 12px 0 0;">
                        <a
                            href="https://www.linkedin.com/in/swimmer-zone/"
                            title="LinkedIn"
                        >
                            <img
                                src="{{ config('app.url') }}/images/email/linkedin.png"
                                alt="LinkedIn"
                                width="20"
                                height="20"
                                style="
                                    display: block;
                                    width: 20px;
                                    height: 20px;
                                    border: 0;
                                "
                            >
                        </a>
                    </td>

                    {{-- Instagram --}}
                    <td style="padding: 0 12px 0 0;">
                        <a
                            href="https://www.instagram.com/omegas_zone/"
                            title="Instagram"
                        >
                            <img
                                src="{{ config('app.url') }}/images/email/instagram.png"
                                alt="Instagram"
                                width="20"
                                height="20"
                                style="
                                    display: block;
                                    width: 20px;
                                    height: 20px;
                                    border: 0;
                                "
                            >
                        </a>
                    </td>

                    {{-- GitHub --}}
                    <td style="padding: 0 12px 0 0;">
                        <a
                            href="https://github.com/omegas-zone"
                            title="GitHub"
                        >
                            <img
                                src="{{ config('app.url') }}/images/email/github.png"
                                alt="GitHub"
                                width="20"
                                height="20"
                                style="
                                    display: block;
                                    width: 20px;
                                    height: 20px;
                                    border: 0;
                                "
                            >
                        </a>
                    </td>

                    {{-- SoundCloud --}}
                    <td style="padding: 0;">
                        <a
                            href="https://soundcloud.com/omegas-zone/sets"
                            title="SoundCloud"
                        >
                            <img
                                src="{{ config('app.url') }}/images/email/soundcloud.png"
                                alt="SoundCloud"
                                width="20"
                                height="20"
                                style="
                                    display: block;
                                    width: 20px;
                                    height: 20px;
                                    border: 0;
                                "
                            >
                        </a>
                    </td>

                </tr>
            </table>

        </td>
    </tr>
</table>
