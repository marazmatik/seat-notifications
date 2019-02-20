<?php
/**
 * MIT License.
 *
 * Copyright (c) 2019. Felix Huber
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Herpaderpaldent\Seat\SeatNotifications\Actions;


use Exception;
use Herpaderpaldent\Seat\SeatNotifications\Models\SeatNotificationRecipient;

class SubscribeAction
{
    public function execute(array $data)
    {
        $client_id = $data['client_id']; // $request->input('client_id');
        $driver = $data['driver']; //$request->input('driver');
        $notification = $data['notification']; //request->input('notification');
        $is_channel = array_key_exists('is_channel', $data) ? $data['is_channel'] : false;
        $affiliation = array_key_exists('affiliation', $data) ? $data['affiliation'] : null;

        try {
            // create a subscription
            SeatNotificationRecipient::firstOrCreate([
                'channel_id'           => $client_id,
                'notification_channel' => $driver,
                'is_channel'           => $is_channel,
            ])
                ->notifications()
                ->create([
                    'name' => $notification,
                    'affiliation' => $affiliation,
                ]);

            return redirect()->route('seatnotifications.index')->with('success', 'You have successfully subscribed to ' . $notification . ' notification.');

        } catch (Exception $e) {

            return redirect()->route('seatnotifications.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

}