<?php

namespace App\Http\Controllers;


use App\Services\MeetingService;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    private MeetingService $service;

    public function __construct(
        MeetingService $service
    ) { 
        $this->service = $service;
    }

    public function add(Request $request )
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
}
