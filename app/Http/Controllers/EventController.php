<?php

namespace App\Http\Controllers;

use App\Event;
use App\Jobs\TestSendEmail;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

    public function addMember(Request $request)
    {

        $name = $request->input('name');
        $surname = $request->input('surname');
        $email = $request->input('email');
        $event_id = $request->input('event_id');

        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => ['required', 'string', 'max:30', 'min:2', 'alpha'],
            'surname' => ['required', 'string', 'max:30', 'min:2', 'alpha'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:members'],
            'event_id' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            $failed = $validator->messages();
            return response()->json([
                'messages' => $failed,
                'status' => 'fail'
            ], 200);
        }

        $event_ex = Event::where('id', '=', $event_id )
            ->first();

        if (!$event_ex) {
            return response()->json([
                'message' => 'event doesn’t exist',
                'status' => 200
            ], 200);
        }

        $member =  Member::create([
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'event_id' => $event_id,
        ]);

        TestSendEmail::dispatch($member);

        return response()->json([
            'status' => 'success',
            'message' =>'member was created',
            'member' => $member,
        ], 200);

    }

    public function getMembers(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'event_id' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            $failed = $validator->messages();
            return response()->json([
                'messages' => $failed,
                'status' => 'fail'
            ], 200);
        }

        $event_id = $request->input('event_id');
        $event_ex = Event::where('id', '=', $event_id )
            ->first();

        if (!$event_ex) {
            return response()->json([
                'message' => 'event doesn’t exist',
                'status' => 200
            ], 200);
        }
        $member = Member::where('event_id', '=', $event_id)
            ->get();
        if (!$member) {
            return response()->json([
                'message' => 'The event has no members',
                'status' => 200
            ], 200);
        }
        return response()->json([
            'status' => 'success',
            'members' => $member,
        ], 200);
    }

    public function getOneMember(Request $request)
    {
        $member_id = $request->input('member_id');
        $member = Member::where('id', '=', $member_id)
            ->first();
        if (!$member) {
            return response()->json([
                'message' => 'Member doesn’t exist',
                'status' => 200
            ], 200);
        }
        return response()->json([
            'status' => 'success',
            'member' => $member,
        ], 200);

    }

    public function changeMember(Request $request)
    {
        $member_id = $request->input('id');

        $member = Member::where('id', '=', $member_id)
            ->first();
        if (!$member) {
            return response()->json([
                'message' => 'Member doesn’t exist',
                'status' => 200
            ], 200);
        }

        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => ['string', 'max:30', 'min:2', 'alpha'],
            'surname' => ['string', 'max:30', 'min:2', 'alpha'],
            'email' => [ 'string', 'email', 'max:50'],
            'event_id' => ['integer'],
        ]);
        if ($validator->fails()) {
            $failed = $validator->messages();
            return response()->json([
                'messages' => $failed,
                'status' => 'fail'
            ], 200);
        }

        $event_id = $request->input('event_id');
        if($event_id !='')
        {
            $event_ex = Event::where('id', '=', $event_id )
                ->first();
        if (!$event_ex) {
            return response()->json([
                'message' => 'event doesn’t exist',
                'status' => 200
            ], 200);
                         }
        }
        $input = collect(request()->all())->filter()->all();
        Member::where('id', '=', $member_id)->update($input);

        return response()->json([
            'status' => 'Member has been changed',
        ], 200);

    }

    public function deleteMember(Request $request)
    {
        $member_id = $request->input('id');
        $member = Member::where('id', '=', $member_id)
            ->first();
        if (!$member) {
            return response()->json([
                'message' => 'Member doesn’t exist',
                'status' => 200
            ], 200);
        }

     Member::where('id', '=', $member_id)
            ->delete();

        return response()->json([
            'status' => 'User deleted',
        ], 200);
    }

}
