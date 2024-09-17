<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    const PATH_VIEW = 'admin.users.';
    const PATH_UPLOAD = 'users';

    public function edit()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            $user = User::find(auth()->id());
            $data = $request->validated();

            // dd($data);

            if ($request->avatar) {
                $data['avatar'] = Storage::put(self::PATH_UPLOAD, $request->avatar);
                $user->avatar = $data['avatar'];
            }

            $user->bio = $data['bio'];
            $user->date_of_birth = $data['date_of_birth'];
            $user->save();

            notify()->success('Profile updated successfully');
            return redirect()->route('admin.index');
        } catch (\Exception $e) {
            Log::error('Error in update user: ' . $e->getMessage());
            return back();
        }
    }
}
