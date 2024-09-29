<?php

namespace App\Functions;

use Illuminate\Mail\Mailables\Address;
use App\Mail\{
    Reset as ResetMail,
    Plain as PlainMail,
};
use Illuminate\Support\{
    Facades\Mail as Mailer,
    Facades\DB as DB,
    Str,
};
use App\Models\Admin;

class Mail
{
    public const FORGOT = "FORGOT";

    public static function reset($email)
    {
        $admin = Admin::where('email', $email)->first();

        if (!$admin) {
            return false;
        }

        $token = Str::random(20);

        $row = DB::table('password_reset_tokens')->where('email', $admin->email)->first();

        if (!$row) {
            DB::table('password_reset_tokens')->insert([
                'email' => $admin->email,
                'token' => $token,
            ]);
        } else {
            DB::table('password_reset_tokens')->where('email', $admin->email)->update([
                'token' => $token,
            ]);
        }

        $mail = new ResetMail([
            'token' => $token,
            'logo' => asset('img/logo.png'),
            'to' => new Address($admin->email, strtoupper($admin->last_name) . ' ' . ucfirst($admin->first_name)),
            'color' => $admin->Setting ? Core::themesList($admin->Setting->theme_color)[0] : '33 150 243',
        ]);
        Mailer::send($mail);

        return true;
    }

    public static function plain($data)
    {
        $mail = new PlainMail($data);
        Mailer::send($mail);
    }
}
