<?php

namespace App\Functions;

use App\Mail\{
    Reset as ResetMail,
    Plain as PlainMail,
};
use Illuminate\Support\{
    Facades\Mail as Mailer,
    Facades\DB as DB,
    Str,
};
use App\Models\User;
use Illuminate\Mail\Mailables\Address;

class Mail
{
    public const FORGOT = "FORGOT";

    public static function reset($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        $token = Str::random(20);

        $row = DB::table('password_reset_tokens')->where('email', $user->email)->first();

        if (!$row) {
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => $token,
            ]);
        } else {
            DB::table('password_reset_tokens')->where('email', $user->email)->update([
                'token' => $token,
            ]);
        }

        $mail = new ResetMail([
            'token' => $token,
            'logo' => $user->Owner ? $user->Owner->Image->Link : asset('img/logo.png'),
            'to' => new Address($user->email, strtoupper($user->last_name) . ' ' . ucfirst($user->first_name)),
            'color' => $user->Preference ? Core::themesList($user->Preference->theme_color)[0] : '33 150 243',
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
