<x-mail::message>
    # Introduction

    Your meeting has been scheduled with:
    {{ $user->name }}
    {{ $user->email }}
    {{ $user->organisation }}
    {{ date('D, d M Y H:i:s', strtotime($meeting->meeting_date)) }}


    Thanks,
    {{ config('app.name') }}
</x-mail::message>
