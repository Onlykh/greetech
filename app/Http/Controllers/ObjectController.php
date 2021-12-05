<?php

namespace App\Http\Controllers;

use App\Models\Instruction;
use App\Models\ObjectToCollect;
use App\Models\UserHistory;

class ObjectController extends Controller
{
    public function collectGuide(string $objectName)
    {
        $object = ObjectToCollect::where('unique_name', $objectName)->first();
        if (!$object) {
            return response(
                [
                    'guide_status' => 'failed',
                ],
                400
            );
        }
        $instructions = Instruction::where('id', $object->instrections_id)->first();
        $imageJson = json_decode($instructions->image);
        $images = [];

        foreach ($imageJson as $image) {
            array_push(
                $images,
                [
                    'url' => 'https://menaesports.biz/app/images/' . $image,
                ]
            );
        }
        return response(

            [
                'guide_status' => 'success',
                'guide_images' => $images,
            ], 200
        );
    }
    /**
     * @param int $count
     */
    public function requestCollect($name, int $count)
    {
        $object = ObjectToCollect::where('unique_name', $name)->first();
        if (!$object) {
            return response(
                [
                    'message' => 'unrecyclable',
                ],
                400
            );
        }
        if ($count < 30) {
            return response(
                [
                    'Bad request',
                ],
                400
            );
        }
        $history = new UserHistory();
        $history->object_id = $object->id;
        $history->user_id = 1;
        $history->count = $count;
        $history->save();
        return response(
            [
                'ezpz', 200,
            ]
        );
    }
    public function history()
    {
        $historys = UserHistory::where('user_id', 1)->get();
        $response = [];
        foreach ($historys as $history) {
            $object = ObjectToCollect::where('id', $history->id)->first();

            array_push(
                $response,
                [
                    'id' => $history->id,
                    'object' => $object,
                    'count' => $history->count,
                    'deliver_time' => $history->deliver_time,
                    'collection' => $history->collection_id,
                ]
            );
        }
        return $response;
    }
}