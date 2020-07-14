<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => ['required', 'string', 'max:30', 'min:2', 'alpha'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:30'],
        ]);
        if ($validator->fails()) {
            $failed = $validator->messages();
            return response()->json([
                'messages' => $failed,
                'status' => 'fail'
            ], 200);
        }


        $input['password'] = Hash::make($request->password);
        $user = User::create($input);
        $success['token'] =  $user->createToken('TestApp')->accessToken;
        return response()->json([
            'token' => $success['token'],
            'status' => 'success'
        ], 200);
    }

    public function login(Request $request)
    {
        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();
        $data = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => request('email'),
            'password' => request('password'),
        ];

        $request = Request::create('/oauth/token', 'POST', $data);

        $response = app()->handle($request);

        $data = json_decode($response->getContent());

        // Формируем окончательный ответ в нужном формате
        return response()->json([
            'token' => $data->access_token,
            'status' => 200
        ]);
    }

}
