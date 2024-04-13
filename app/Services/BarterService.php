<?php

namespace App\Services;

use App\Http\Resources\BarterResource;
use App\Models\Barter;
use App\Models\Status;
use App\Models\User;

class BarterService
{
    public function add_new_add($request): ?Status
    {
        $status = new Status();
        try {
            if (User::where("acc_token", $request->input('token'))->exists()) {
                $barter = new Barter();
                $barter->title = $request->get("title");
                $barter->img = $request->get("img");
                $barter->setImage($barter, $request);
                $barter->comments = $request->get("comments");
                $barter->contacts = $request->get("contacts");
                $barter->price = $request->get("price");
                $barter->stud_number = $request->get("stud_number");
                $barter->sender_name = $request->get("sender_name");
                $barter->approved = false;
                $barter->save();
                $status->status = "success";
                return $status;
            }
            else {
                return null;
            }
        }
        catch (\Exception)
        {
            $status->status = 'fail';
            return $status;
        }
    }

    public function find_approved($request): ?\Illuminate\Http\JsonResponse
    {
        if (User::where("acc_token", $request->input('token'))->exists()) {
            $paginator = Barter::where('approved', true)
                ->orderBy("id", "desc")
                ->cursorPaginate(10);
            $array = [];
            foreach ($paginator->items() as $item) {
                $array[] = new BarterResource($item);
            }
            return response()->json([
                "data" => $array,
                "meta" => [
                    "next_url" => $paginator->nextPageUrl(),
                    "code" => 200
                ]
            ]);
        } else {
            return null;
        }
    }

    public function find_not_approved($request): ?\Illuminate\Http\JsonResponse
    {
        if (User::where("acc_token", $request->input('token'))->value('is_admin')) {
            $paginator = Barter::where('approved', false)
                ->orderBy("id", "desc")
                ->cursorPaginate(10);
            $array = [];
            foreach ($paginator->items() as $item) {
                $array[] = new BarterResource($item);
            }
            return response()->json([
                "data" => $array,
                "meta" => [
                    "next_url" => $paginator->nextPageUrl(),
                    "code" => 200
                ]
            ]);
        } else {
            return null;
        }
    }

    public function approve_add($request): ?Status
    {
        $status = new Status();
        try {
            if (User::where("acc_token", $request->input('token'))->value('is_admin')) {
                $id = $request->input('id');
                $barter = Barter::find($id);
                if ($barter == null) {
                    throw new \Exception('Объект не найден.');
                }
                $barter->approved = true;
                $barter->save();
                $status->status = 'success';
            }
            else {
                $status->status = 'fail';
            }
            return $status;
        }
        catch (\Exception) {
            return null;
        }
    }

    public function deny_add($request): ?Status
    {
        $status = new Status();
        try {
            if (User::where("acc_token", $request->input('token'))->value('is_admin')) {
                $id = $request->input('id');
                $barter = Barter::find($id);
                if ($barter) {
                    if (!empty($barter->img)) {
                        $barter->deleteImage($barter);
                    }
                    $barter->forceDelete();
                    $status->status = "success";
                    return $status;
                } else {
                    return null;
                }
            }
            else {
                $status->status = 'fail';
                return $status;
            }
        }
        catch (\Exception) {
            return null;
        }
    }
}
