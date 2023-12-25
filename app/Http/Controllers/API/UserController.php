<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->role != 9999) {
            return response()->json([
                'success' => false
            ], response::HTTP_NOT_FOUND);
        }
        $list_user = User::where('id', '!=', '1')->get();
        return response()->json([
            'success' => true,
            'list_user' => $list_user,
        ], response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public $successStatus = 200;
    public $badRequestStatus = 403;

    public function login()
    {
        if (Auth::attempt(['user_name' => request('user_name'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('doantotnghiep')->accessToken;
            return response()->json(['success' => true, 'data' => $success], $this->successStatus);
        } else {
            return response()->json(['success' => false], 401);
        }
    }

    public function register(Request $request)
    {
        $clsUser = new User();
        
        if (Auth::user()->role != 9999) return response()->json(['success' => false], $this->badRequestStatus);

        $validator = Validator::make($request->all(), [
            'id_number' => 'required',
            'fullname' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false], $this->badRequestStatus);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['user_name'] = $input['id_number'];
        
        if(@$input['avatar']) $input['avatar'] =$clsUser->base64ToImage($input['avatar']);
        
        $user = User::create($input);
        return response()->json(['success' => true], $this->successStatus);
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => true, 'data' => $user], $this->successStatus);
    }

    public function change_password(Request $request)
    {
        if ($request->c_new_pass != $request->new_pass || !Hash::check($request->current_pass, Auth::user()->password)) {
            return response()->json([
                'success' => false
            ], $this->successStatus);
        }
        $user_id = Auth::user()->id;

        $user = User::find($user_id);
        $user->update([
            "password" => bcrypt($request->new_pass),
            "password_changed" => true
        ]);
        $user->save();
        return response()->json([
            'success' => true,
        ]);
    }

    public function delete_user(int $user_id)
    {
        if (Auth::user()->role != 9999) {
            return response()->json([
                'success' => false
            ], $this->successStatus);
        }
        $user = User::findOrFail($user_id);
        $user->delete();
        return response()->json([
            'success' => true
        ], response::HTTP_OK);
    }

    public function update_self_info(Request $request)
    {
        $clsUser = new User();
        $user = Auth::user();
        if ($user != null) {
            $user_id = $user->id;
           // if($user_id != $request){
                $user = User::findOrFail($user_id);
                $data = $request->all();
                if(@$data['avatar']) $data['avatar'] =$clsUser->base64ToImage($data['avatar']);
                $user->update($data);
                $user->save();
                return response()->json([
                    'success' => true,
                    'data'=> $user
                ], response::HTTP_OK);
            //}
        } else {
            return response()->json([
                'success' => false
            ], response::HTTP_OK);
        }
    }

    public function update_user_info(Request $request, int $user_id)
    {
        $clsUser = new User();
        $user = User::findOrFail($user_id);
        if (Auth::user()->role != 9999 || $user->role == 9999) {
            return response()->json([
                'success' => false,
                'message' => 'Permittion error'
            ], response::HTTP_OK);
        } else {
            $input = $request->all();
            if(@$input['avatar']) $input['avatar'] =$clsUser->base64ToImage($input['avatar']);
            $user->update($input);
            $user->save();
        }
        return response()->json([
            'success' => true
        ], response::HTTP_OK);
    }

    public function get_user_by_rfid(string $rfid)
    {
        $user = User::where('rfid', $rfid)->first();

        return response()->json([
            'success' => true,
            'data' =>  $user
        ], response::HTTP_OK);
    }

    public function reset_password(Request $request)
    {
        if (Auth::user()->role != 9999) return response()->json(['success' => false], $this->badRequestStatus);

        $validator = Validator::make($request->all(), [
            'uid' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false], $this->badRequestStatus);
        }

        $user = User::find($request["uid"]);
        $user->update([
            "password" => bcrypt("123456"),
            "password_changed" => false
        ]);
        $user->save();

        return response()->json([
            'success' => true,
        ]);
    }

    public function update_rfid(Request $request)
    {
        if (Auth::user()->role != 9999) return response()->json(['success' => false], $this->badRequestStatus);

        $validator = Validator::make($request->all(), [
            'rfid' => 'required',
            'uid' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false], $this->badRequestStatus);
        }

        $uCheck = User::where('rfid', $request['rfid'])->first();

        if($uCheck != null){
            return response()->json(['success' => false], $this->badRequestStatus);
        }

        $user = User::find($request["uid"]);
        $user->update([
            "rfid" => $request['rfid']
        ]);
        $user->save();

        return response()->json([
            'success' => true,
        ]);
    }
}
