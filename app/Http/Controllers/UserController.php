<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')->paginate(15);
        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,laboratorio,administracion'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'suspended' => false,
        ]);

        ActivityLog::log('user_created', "Usuario creado: {$user->email} con rol {$user->role}");

        return redirect()->route('dashboard.usuarios')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,laboratorio,administracion'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        ActivityLog::log('user_updated', "Usuario actualizado: {$user->email} (rol: {$user->role})");

        return redirect()->route('dashboard.usuarios')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Toggle the suspension status of a user.
     */
    public function toggleSuspension(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['suspension' => 'No puede suspender su propia cuenta de administrador.']);
        }

        $user->suspended = !$user->suspended;
        $user->save();

        $action = $user->suspended ? 'user_suspended' : 'user_reactivated';
        $statusText = $user->suspended ? 'suspendido' : 'reactivado';
        
        ActivityLog::log($action, "Usuario {$statusText}: {$user->email}");

        return redirect()->route('dashboard.usuarios')->with('success', "El usuario ha sido {$statusText} correctamente.");
    }

    /**
     * Display the activity bitacora logs.
     */
    public function activityLogs()
    {
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(30);
        return view('dashboard.activity-logs', compact('logs'));
    }
}
