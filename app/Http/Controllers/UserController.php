<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class UserController extends Controller
{

public function index() {

}

public function create() {

}
public function store(Request $request) {

    Gate::authorize('create', User::class);
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'role' => 'required|in:user,admin,jurnalist',
    ]);
    $user = User::create($request->only('name', 'email', 'password', 'role'));
    return response()->json([
        'message' => 'User successfully created',
        'data' => UserResource::make($user),
    ], 201);
}

public function show($id) {
    //
}

public function edit($id) {
    //
}

public function update(Request $request, $id) {
    
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        'role' => 'required|in:user,admin,jurnalist',
    ]);

    $user->update($validated);

    return response()->json([
        'message' => 'User successfully updated',
        'data' => UserResource::make($user),
    ]); 
}
public function destroy($id) {
    //

}

}
