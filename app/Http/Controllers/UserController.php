<?php

namespace App\Http\Controllers;

use App\ConstantMessage;
use App\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        $rules = [
            'nama'   => 'required|max:255',
            'alamat' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return response()->json([
                'message' => ConstantMessage::ValidationFailedMessage,
                'errors'  => $validation->errors(),
            ], ConstantMessage::ValidationFailedStatus);
        }

        $check = UserModel::where('nama', $request->nama)->first();
	
		if ($check) {
			return response()->json([
                'message' => ConstantMessage::DataIsExist,
                'errors'  => ['nama'=>'Nama Sudah Terpakai'],
            ], ConstantMessage::InternalServerErrorStatus);
		}

        try {
            DB::beginTransaction();

            $user_data['nama']   = $request->nama;
            $user_data['alamat'] = $request->alamat;
            $user                = UserModel::create($user_data);

            DB::commit();

            return response()->json([
                'message' => ConstantMessage::CreateUserSuccess,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => ConstantMessage::InternalServerErrorMessage,
            ], ConstantMessage::InternalServerErrorStatus);
        }
    }

    public function getUser()
    {
        $user = UserModel::latest()->get();
        return response()->json([
            'data' => $user,
        ]);
    }
}
