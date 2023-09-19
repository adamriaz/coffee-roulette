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

    public function add(Request $request)
    {
        return $this->service->add($request->meeting_date);
    }

    public function addUser(Request $request)
    {
        $userId = $request->user_id;
        $meetingId = $request->meeting_id;

        if ($userId == null || $meetingId == null) {
            abort(400, "Bad request");
        }
        return $this->service->addUser($userId, $meetingId);
    }

    public function removeUser(Request $request)
    {
        $userId = $request->user_id;
        $meetingId = $request->meeting_id;

        if ($userId == null || $meetingId == null) {
            abort(400, "Bad request");
        }
        return $this->service->removeUser($userId, $meetingId);
    }

    public function findMatchingUser()
    {
        $newUser = $this->service->getNextMatchingUser();
        $findMeeting = $this->service->findNextMeeting(false);
        $meeting = null;
        $currentUserId = auth()->user()->id;

        if ($findMeeting == null || empty($findMeeting->toArray())) {
            $meetingObj = $this->service->add(now()); // Add 30 days ahead to this
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

    public function checkIfEmailHasBeenSent(int $meetingId, String | null $emailSentDate) {
       
        if ($emailSentDate == null) {
            
            $this->emailService->notifyMeeting($meetingId);
        }
    }
}
