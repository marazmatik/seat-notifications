<?php
/**
 * Created by PhpStorm.
 * User: felix
 * Date: 27.12.2018
 * Time: 20:55.
 */

namespace Herpaderpaldent\Seat\SeatNotifications\Http\Controllers\Slack;

use Herpaderpaldent\Seat\SeatNotifications\Http\Controllers\BaseNotificationChannelController;

class SlackNotificationChannelController extends BaseNotificationChannelController
{
    public function getSettingsView() :string
    {
        return 'seatnotifications::slack.settings';
    }

    public function getRegistrationView() :string
    {
        return 'seatnotifications::slack.registration';
    }

    public function getChannels()
    {
        if(is_null(setting('herpaderp.seatnotifications.slack.credentials.token', true)))
            return ['slack' => []];

        $response = cache('herpaderp.seatnotifications.slack.channels');

        if(is_null($response)){

            $channels = app('slack')
                ->conversationsList([
                    'exclude_archived' => true,
                    'types' => 'public_channel,private_channel',
                ])
                ->getChannels();

            $response = collect();

            foreach ($channels as $channel)
                $response->push($channel);

            cache(['herpaderp.seatnotifications.slack.channels' => $response], now()->addMinutes(5));

        }

        return ['slack' => $response->map(function ($item) {
            return collect([
                'name' => $item->name,
                'id' => $item->id,
                'private_channel' => $item->is_group,
            ]);
        })];
    }
}