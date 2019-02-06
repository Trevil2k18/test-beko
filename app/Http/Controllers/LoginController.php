<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\UserLoginRequest;
use App\Models\BannedIp;
use App\Models\User;

class LoginController extends Controller
{
    const BANNED_MESSAGE = 'Banned by IP';
    const LOGGED_IN = 'Successfully logged in!';
    const INVALID_CREDS = 'Invalid credentials';

    public function login(UserLoginRequest $request)
    {
        /** @var User $user */
        $user = User::login($request->get('email'), $request->get('password'))->first();
        /** @var BannedIp $bannedIp */
        $bannedIp = BannedIp::ipInt(ip2long($request->getClientIp()))->first();

        if (!$user) {
            if (!$bannedIp) {
                BannedIp::create([
                    'ip_string' => $request->getClientIp(),
                    'ip_int' => ip2long($request->getClientIp()),
                ]);
                $message = self::INVALID_CREDS;
                $code = 401;
            } else {
                if ($bannedIp->isBanned()) {
                    $message = self::BANNED_MESSAGE;
                    $code = 403;
                } else {
                    $bannedIp->incrementTries();
                    $message = self::INVALID_CREDS;
                    $code = 401;
                }
            }
        } else {
            $bannedIp->dropTriesCounter();
            $message = self::LOGGED_IN;
            $code = 200;
        }

        return response()->json(['message' => $message], $code);
    }
}
