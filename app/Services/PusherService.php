<?php

namespace App\Services;

use Pusher\Pusher;

class PusherService
{
    public function init()
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        try {
            $pusher->get('/channels');
        } catch (\Exception $e) {
            return redirect()->route('queues.index')->with('error', $e->getMessage());
        }

        return $pusher;
    }
}
