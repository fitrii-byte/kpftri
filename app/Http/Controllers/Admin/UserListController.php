<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserListController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));

        $users = User::query()
            ->where('role', 'user')
            ->when($q !== '', fn ($query) => $query->where('name', 'like', "%$q%")->orWhere('email', 'like', "%$q%"))
            ->orderByDesc('last_login_at')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.pengguna', compact('users', 'q'));
    }

    public function destroy(Request $request, User $user)
    {
        abort_unless($user->role === 'user', 404);

        $user->delete();

        return back()->with('status', 'Pengguna berhasil dihapus.');
    }
}