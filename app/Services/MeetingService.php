<?php

namespace App\Services;

use App\Models\Meeting;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class MeetingService {
    
    /**  
     * Adds a single meeting
     * @param String $meetingDate 
     * @return Meeting
     *
     */
    public function add(String $meetingDate)
    {
        $meeting = new Meeting();
        $meeting->meeting_date = $meetingDate;
        $meeting->save();
        return $meeting;
    }

    public function addUser(int $userId, int $meetingId) {
        
        try {            
            $user = User::find($userId);
            $meeting = Meeting::find($meetingId);
            if ($user == null || $meeting == null) {
                abort(400, "Bad Request");
            }
            $meeting->users()->syncWithoutDetaching($user);
        } catch(ModelNotFoundException $e) {
            abort(400, $e->getMessage());
        }
    }

    public function removeUser(int $userId, int $meetingId) {        
        try {            
            $user = User::find($userId);
            $meeting = Meeting::find($meetingId);
            if ($user == null || $meeting == null) {
                abort(400, "Bad Request");
            }
            $meeting->users()->detach($user);
        } catch(ModelNotFoundException $e) {
            abort(400, $e->getMessage());
        }
    }

    public function findNextMeeting() {

    }

    public function findMatchingUser() {

    }

    public function arrangeMeetingAndNotify() {

    }
}