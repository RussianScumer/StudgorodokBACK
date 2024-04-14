<?php

namespace App\Services;

use App\Http\Resources\BarterResource;
use App\Models\Barter;
use App\Models\Status;
use App\Models\User;

class BarterService
{
    public function add_image_to_ad($request): ?Status
    {
        $status = new Status();
        try {
            $barter = Barter::find($request->input("id"));
            if (User::where("acc_token", $request->input('token'))->exists() &&
                $barter->stud_number == $request->input("stud_number") &&
                $barter->id == $request->input("id")) {

                if (count(explode(" ", $barter->img)) > 5) {
                    $status->status = 'max';
                }
                else {
                    if ($request->filled("img")) {
                        $barter->setImage($barter, $request);
                        $barter->save();
                        $status->status = 'success';
                    }
                    else {
                        $status->status = 'fail';
                    }
                }
                return $status;
            }
            else {
                return null;
            }
        }
        catch (\Exception) {
            $status->status = 'fail';
            return $status;
        }
    }
    public function add_new_ad($request): ?Status
    {
        $status = new Status();
        try {
            if (User::where("acc_token", $request->input('token'))->exists()) {
                $barter = new Barter();
                $barter->title = $request->get("title");
                if (!$request->filled("description")) {
                    $barter->description = "";
                }
                else {
                    $barter->description = $request->get("description");
                }
                $barter->contacts = $request->get("contacts");
                $barter->price = $request->get("price");
                $barter->stud_number = $request->get("stud_number");
                $barter->sender_name = $request->get("sender_name");
                $barter->approved = false;
                $barter->img = "";
                $barter->save();
                $status->status = (string) $barter->id;
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

    public function approve_ad($request): ?Status
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

    public function deny_ad($request): ?Status
    {
        $status = new Status();
        try {
            if (User::where("acc_token", $request->input('token'))->value('is_admin') ||
                User::where("acc_token", $request->input('token'))->value('userid') == $request->input('stud_number')) {
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
