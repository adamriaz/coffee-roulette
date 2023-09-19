<?php

namespace App\Services;

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MeetingService
{

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

    /**
     * @param int $userId
     * @param int $meetingId
     * 
     * @return void
     */
    public function addUser(int $userId, int $meetingId)
    {

        try {
            $user = User::find($userId);
            $meeting = Meeting::find($meetingId);
            if ($user == null || $meeting == null) {
                abort(400, "Bad Request");
            }
            $meeting->users()->syncWithoutDetaching($user);
        } catch (ModelNotFoundException $e) {
            abort(400, $e->getMessage());
        }
    }

    /**
     * @param int $userId
     * @param int $meetingId
     * 
     * @return void
     */
    public function removeUser(int $userId, int $meetingId)
    {
        try {
            $user = User::find($userId);
            $meeting = Meeting::find($meetingId);
            if ($user == null || $meeting == null) {
                abort(400, "Bad Request");
            }
            $meeting->users()->detach($user);
        } catch (ModelNotFoundException $e) {
            abort(400, $e->getMessage());
        }
    }


    /**
     * @param bool $hasMet
     * 
     * @return Meeting
     */
    public function findNextMeeting(bool $hasMet)
    {
        $nextMeeting = Meeting::where('has_met', $hasMet)
            ->with('users')
            ->whereHas('users', function ($query) {
                $id = auth()->user()->id;
                $query->where('user_id', $id);
            })->inRandomOrder()->get();
        return $nextMeeting;
    }

    /**
     * @return int $matchedUserId
     */
    public function findMatchingUser()
    {
        // Checks available users who are not company related
        $organisation = auth()->user()->organisation;
        $usersNotFromSameCompany = User::select('id')->where('organisation', '!=', $organisation)->inRandomOrder()->get()->flatten()->toArray();
        $usersNotFromSameCompany = array_column($usersNotFromSameCompany, 'id');

        $matchedUserId = null;
        // Checks all other passed meetings by user
        $mappedUsersFromMeetings = $this->findNextMeeting(true)->map(function ($item) {
            return $item->users;
        })->flatten()->toArray();
        $usersFromMeetings = array_column($mappedUsersFromMeetings, 'id');

        // Checks if one of these users where not in that meeting to find a not yet met pair
        foreach ($usersNotFromSameCompany as $userId) {
            if (!in_array($userId, $usersFromMeetings)) {
                $matchedUserId = $userId;
            }
        }

        return $matchedUserId;
    }

    public function getNextMatchingUser()
    {
        $matchedUserId = $this->findMatchingUser();
        if ($matchedUserId != null) {
            return User::find($matchedUserId);
        } else {
            return null;
        }
    }
}
