<?php

namespace App\Services;

use App\Models\Canteen;
use App\Models\Status;
use App\Models\User;

class CanteenService
{
    public function add_dish($request): ?Status
    {
        $status = new Status();
        try {
            if (User::where("acc_token", $request->input('token'))->value('is_admin')) {
                $canteen = new Canteen();
                $canteen->title = $request->get("title");
                $canteen->price = $request->get("price");
                $canteen->type = $request->get("type");
                $canteen->img = $request->get("img");
                $canteen->setImage($canteen, $request);
                $canteen->save();
                $status->status = "success";
                return $status;
            } else {
                return null;
            }
        } catch (\Exception) {
            return null;
        }
    }

    public function show_menu($request)
    {
        if (User::where("acc_token", $request->input('token'))->exists()) {
            return Canteen::all();
        } else {
            return null;
        }
    }

    public function update_dish($request)
    {
        $status = new Status();
        try {
            if (User::where("acc_token", $request->input('token'))->value('is_admin')) {
                $id = $request->input('id');
                $canteen = Canteen::find($id);
                $canteen->title = $request->get("title");
                $canteen->price = $request->get("price");
                $canteen->type = $request->get("type");
                if ($request->get("img") != "unchanged") {
                    if (!empty($canteen->img)) {
                        $canteen->deleteImage($canteen);
                    }
                    $canteen->img = $request->get("img");
                    $canteen->setImage($canteen, $request);
                }
                $canteen->save();
                $status->status = "success";
                return $status;
            } else {
                return null;
            }
        } catch (\Exception) {
            return null;
        }
    }

    public function delete_dish($request): ?Status
    {
        $status = new Status();
        try {
            if (User::where("acc_token", $request->input('token'))->value('is_admin')) {
                $id = $request->input('id');
                $canteen = Canteen::find($id);
                if ($canteen) {
                    if (!empty($canteen->img)) {
                        $canteen->deleteImage($canteen);
                    }
                    $canteen->forceDelete();
                    $status->status = "success";
                } else {
                    $status->status = 'fail';
                }
                return $status;
            }
            else {
                return null;
            }
        }
        catch (\Exception) {
            return null;
        }
    }
}
