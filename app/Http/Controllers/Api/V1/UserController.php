<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\V1\UserResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\HttpResponses;

class UserController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'ability:user-get']);
    }

    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        \Log::info('User show called', [
            'user_id' => $user->id,
            'auth_user' => auth()->user() ? auth()->user()->id : 'not authenticated',
        ]);
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
