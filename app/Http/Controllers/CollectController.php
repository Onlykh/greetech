<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\ObjectToCollect;
use App\Models\User;
use App\Models\UserHistory;

class CollectController extends Controller
{
    public function usersToCollect()
    {
        $collections = Collection::where('collector_id', 2)
            ->get();
        $response = [];
        foreach ($collections as $collection) {
            $users = User::where('region_id', $collection->region_id)->get();
            foreach ($users as $user) {
                $requests = UserHistory::where('user_id', $user->id)
                    ->where('deliver_time', null)->first();
                if ($requests) {
                    array_push(
                        $response,
                        $user
                    );
                }
            }
        }
        return response(
            $response, 200
        );
    }
    public function UserRequest($user_id = 1)
    {
        $user = User::where('id', $user_id)->first();
        $userHistory = UserHistory::where('user_id', $user_id)
            ->where('collection_id', null)->first();
        $object = ObjectToCollect::where('id', $userHistory->object_id)->first();

        return response([
            'map' => [
                'longitude' => $user->longitude,
                'laltitude' => $user->longitude,
            ],
            'data' => [
                'request_id' => $userHistory->id,
                'count' => $userHistory->count,
                'object' => [
                    'id' => $object->id,
                    'title' => $object->unique_name,
                    'image' => $object->pic,
                ],
            ],
        ]);
    }
    public function collected($request_id, $amount)
    {
        //$amount = $request->amount;
        $userHistory = UserHistory::where('id', $request_id)->first();
        $object = ObjectToCollect::where('id', $userHistory->object_id)->first();
        $userHistory->amount = $amount * $object->buy_price;
        $userHistory->deliver_time = now();
        $userHistory->collection_id = 1;
        $userHistory->save();
        $user = User::where('id', $userHistory->user_id)->first();
        $user->ballance += $amount * $object->buy_price;
        $user->save();
        return response(
            [
                'success',
            ], 200
        );
    }
}