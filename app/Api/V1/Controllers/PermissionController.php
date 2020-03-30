<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PermissionController extends Controller
{
        /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function viewGroupName($permissionId)
    {
        $roles = \App\Role::whereHas('permissions', function($q) use ($permissionId){
            $q->where('permissions.id', '=', $permissionId);
        })->whereEnabled(true)->select(['name', 'description'])->get();

        return response()->json([
            'code' => 200,
            'data' => ['roles'=>$roles],
        ],200);
    }




}