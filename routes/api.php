<?php

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/v1', function (Request $request) {
    $users = User::query()
        ->when($request->q != null, function ($query) use ($request) {
            return $query->where('email', 'like', '%' . $request->q . '%')
                ->orWhere('first_name', 'like', '%' . $request->q . '%')
                ->orWhere('last_name', 'like', '%' . $request->q . '%');
        })->paginate();
    return UserResource::collection($users);
});
