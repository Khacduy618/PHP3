<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Import User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import Hash facade
use Illuminate\Validation\Rules;    // Import Rules namespace
use Illuminate\Support\Facades\Storage; // Import Storage facade
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; // Import Auth facade if not already imported

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = "Quản lý Người dùng - Danh sách";
        $title = "Danh sách Người dùng";
        // Fetch users including soft-deleted, order by status (deleted last), then by creation date
        $users = User::withTrashed()
            ->orderByRaw('deleted_at IS NULL DESC') // Active users first
            ->orderBy('created_at', 'desc')->get();

        // Assuming the view will be at resources/views/admin/users/list.blade.php
        return view('admin.users.list', compact('users', 'title', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_title = "Quản lý Người dùng - Thêm mới";
        $title = "Thêm Người dùng mới";

        // Assuming the view will be at resources/views/admin/users/add.blade.php
        return view('admin.users.add', compact('title', 'page_title'));
    }




    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:user,admin'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Avatar validation
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            // Store in 'avatars' directory within 'public' disk
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'avatar' => $avatarPath, // Save avatar path
            // Add email_verified_at if you want to auto-verify admin-created users
            // 'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id); // Find user or fail
        $page_title = "Quản lý Người dùng - Chỉnh sửa";
        $title = "Chỉnh sửa Người dùng: " . $user->name;

        // Assuming the view will be at resources/views/admin/users/edit.blade.php
        return view('admin.users.edit', compact('user', 'title', 'page_title'));
    }





    public function update(Request $request, string $id)
    {
        // Find user, including soft-deleted ones for the restore functionality
        $user = User::withTrashed()->findOrFail($id);

        // Handle Restore Action first
        if ($request->has('restore')) {
            $user->restore();
            return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được khôi phục thành công!');
        }

        // Proceed with regular update validation and logic
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Ensure email is unique, ignoring the current user's email
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // Password is optional, but if provided, must meet requirements and be confirmed
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:user,admin'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Avatar validation
        ]);

        // Prepare data for update
        $data = $request->only(['name', 'email', 'role']);

        // Handle optional password update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle optional avatar update
        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Store new avatar
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Update the user
        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Thông tin người dùng đã được cập nhật thành công!');
    }



    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting the currently authenticated user
        if (Auth::id() == $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Bạn không thể xóa chính mình.');
        }

        // Delete avatar if it exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Delete the user
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa thành công!');
    }
}
