<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AdminManagementController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));

        $admins = User::query()
            ->where('role', 'admin')
            ->when($q !== '', fn ($query) => $query->where('name', 'like', "%$q%")->orWhere('email', 'like', "%$q%"))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.admin-management', compact('admins', 'q'));
    }

    public function create()
    {
        return view('admin.admin-form', ['admin' => new User()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', Password::min(6)],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'no_hp' => $data['no_hp'] ?? null,
            'password' => $data['password'],
            'role' => 'admin',
        ]);

        return redirect()->route('admin.admin.index')->with('status', 'Akun admin berhasil ditambahkan.');
    }

    public function edit(User $admin)
    {
        abort_unless($admin->isAdmin(), 404);

        return view('admin.admin-form', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        abort_unless($admin->isAdmin(), 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,'.$admin->id],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', Password::min(6)],
        ]);

        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->no_hp = $data['no_hp'] ?? null;
        if (! empty($data['password'])) {
            $admin->password = $data['password'];
        }
        $admin->save();

        return redirect()->route('admin.admin.index')->with('status', 'Akun admin berhasil diperbarui.');
    }

    public function destroy(Request $request, User $admin)
    {
        abort_unless($admin->isAdmin(), 404);

        if ($admin->id === $request->user()->id) {
            return back()->withErrors(['admin' => 'Anda tidak bisa menghapus akun sendiri.']);
        }

        $admin->delete();

        return back()->with('status', 'Akun admin berhasil dihapus.');
    }
}