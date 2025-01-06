<?php

namespace App\Listeners;

use IlluminateAuthEventsLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  IlluminateAuthEventsLogin  $event
     * @return void
     */
    public function handle(/*IlluminateAuthEventsLogin $event*/Login $event)
    {
        $user = $event->user;
        $timestamp = now(); // 現在の日時を取得

        // ログイン日時をログファイルに記録
        Log::info('User logged in', [
            'user_id' => $user->id,
            'email' => $user->email,
            'logged_in_at' => $timestamp
        ]);
    }
}
