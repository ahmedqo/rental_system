<table style="width: 100%;">
    <tr>
        <td style="padding: 16px;">
            <div style="width: 500px; max-width: 100%; margin: auto;">
                <a aria-label="home_page_link"
                    style="width: 160px; max-width: 100%; display: block; text-decoration: unset; margin: auto;">
                    <img src="{{ $data['logo'] }}?v={{ env('APP_VERSION') }}" style="width: 100%; display: block;" />
                </a>
                <p style="color: #1d1d1d; text-align: center; font-size: 16px; margin: 20px 0 30px 0;">
                    {{ __('Did you forget your password?') }}<br />
                    {{ __('No need to worry, we\'ve got you covered! Let us provide you with a new password') }}
                </p>
                <div
                    style="border-radius: 6px;background: rgb({{ $data['color'] }});width: max-content;margin: auto;
                ">
                    <a href="{{ route('views.reset.index', $data['token']) }}" aria-label="reset_page_link"
                        style="display: block;max-width: 100%;text-align: center;color: #fcfcfc;font-weight: 600;font-size: 18px;padding: 12px 32px;text-decoration: unset;">
                        {{ __('Reset password') }}
                    </a>
                </div>
            </div>
        </td>
    </tr>
</table>
