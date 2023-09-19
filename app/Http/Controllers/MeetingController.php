<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Services\MeetingService;
use App\Services\EmailService;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    private MeetingService $service;
    private EmailService $emailService;

    public function __construct(
        MeetingService $service,
        EmailService $emailService,
    ) {
        $this->service = $service;
        $this->emailService = $emailService;
    }

    /**
     * Adds a single Meeting
     * @param Request $request
     * 
     * @return Meeting
     */
    public function add(Request $request)
    {
        return $this->service->add($request->meeting_date);
    }

    /**
     * Adds a user to a Meeting
     * @param Request $request
     * 
     * @return void
     */
    public function addUser(Request $request)
    {
        $userId = $request->user_id;
        $meetingId = $request->meeting_id;

        if ($userId == null || $meetingId == null) {
            abort(400, "Bad request");
        }
        return $this->service->addUser($userId, $meetingId);
    }

    /**
     * Removes a user from a Meeting
     * @param Request $request
     * 
     * @return void
     */
    public function removeUser(Request $request)
    {
        $userId = $request->user_id;
        $meetingId = $request->meeting_id;

        if ($userId == null || $meetingId == null) {
            abort(400, "Bad request");
        }
        return $this->service->removeUser($userId, $meetingId);
    }

    /**
     * Updates has_met flag for a Meeting
     * @param int $meetingId
     * @param bool $hasMet
     * 
     * @return void
     */
    public function updateMeetingMet(Request $request)
    {
        $meetingId = $request->meetingId;
        $hasMet = $request->hasMet;

        if ($hasMet == null || $meetingId == null) {
            abort(400, "Bad request");
        }

        return $this->service->updateMeetingMet($meetingId, $hasMet);
    }


    /**
     * When visiting the Dashboard or homepage after logging in, this function will run to check if there is a match to pair 
     * and if there is meeting scheduled along with a sent email.
     * @return View Dashboard
     */
    public function findMatchingUser()
    {
        $newUser = $this->service->getNextMatchingUser();
        $findMeeting = $this->service->findNextMeeting(false);
        $meeting = null;
        $currentUserId = auth()->user()->id;

        if ($findMeeting == null || empty($findMeeting->toArray())) {
            $time = strtotime(now()->toString());
            $time = date("Y-m-d", strtotime("+1 month", $time));
            $meetingObj = $this->service->add($time);
            $meetingId = $meetingObj->id;
            $this->service->addUser($newUser->id, $meetingId);
            $this->service->addUser($currentUserId, $meetingId);
            $meeting = Meeting::where('id', $meetingId)->first();
            $user = $meeting->users()->where('user_id', '!=', $currentUserId)->get()->first();

            $this->checkIfEmailHasBeenSent($meetingId, $meeting->email_sent_date);
        } else {
            $meetingId = $findMeeting->first()->id;
            $meeting = Meeting::where('id', $meetingId)->first();
            $user = $meeting->users()->where('user_id', '!=', $currentUserId)->get()->first();
            $this->checkIfEmailHasBeenSent($meetingId, $meeting->email_sent_date);
        }

        return View('dashboard', ['user' => $user, 'meeting' => $meeting]);
    }


    /**
     * If no email has been sent, then this will send out an email of the scheduled meeting to the users. 
     * @param int $meetingId
     * @param String | null
     * 
     * @return void
     */
    public function checkIfEmailHasBeenSent(int $meetingId, String | null $emailSentDate)
    {

        if ($emailSentDate == null) {

            $this->emailService->notifyMeeting($meetingId);
        }
    }
}
