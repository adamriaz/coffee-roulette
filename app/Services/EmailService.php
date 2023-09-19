<?php

namespace App\Services;

use App\Mail\MeetingScheduled;
use App\Models\Meeting;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    /**
     * Sends email using a Meeting item and the email addresses of the users.
     * @param int $meetingId
     * 
     * @return void
     */
    public function notifyMeeting(int $meetingId)
    {
        try {
            
            $meeting = Meeting::where('id', $meetingId)->first();
            $meeting->email_sent_date = now();
            $meeting->save();
            $users = $meeting->users()->get();

            foreach ($users as $user) {
                Mail::to($user->email)->send(new MeetingScheduled($meeting, $user));
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
