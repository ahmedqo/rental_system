<table style="width: 100%;">
    <tr>
        <td style="padding: 16px;">
            <div style="width: 500px; max-width: 100%; margin: auto;">
                <a aria-label="home_page_link"
                    style="width: 160px; max-width: 100%; display: block; text-decoration: unset; margin: auto;">
                    <img src="{{ Core::company() ? Core::company('Image')->Link : asset('img/logo.png') }}?v={{ env('APP_VERSION') }}"
                        style="width: 100%; display: block;" />
                </a>
                <p style="color: #1d1d1d; text-align: center; font-size: 16px; margin: 20px 0 30px 0;">
                    {!! nl2br($data['content']) !!}
                </p>
            </div>
        </td>
    </tr>
</table>
