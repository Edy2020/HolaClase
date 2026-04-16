<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Profesor;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UsuarioController extends Controller
{
    public function index()
    {
        $totalUsuarios = User::count();
        $totalProfesores = Profesor::count();
        $totalEstudiantes = Estudiante::count();
        $totalRoles = Role::count();
        $profesoresConAcceso = User::whereNotNull('profesor_id')->count();

        return view('usuarios.index', compact(
            'totalUsuarios',
            'totalProfesores',
            'totalEstudiantes',
            'totalRoles',
            'profesoresConAcceso'
        ));
    }

    public function crear()
    {
        $roles = Role::all();
        return view('usuarios.crear', compact('roles'));
    }

    public function gestionar()
    {
        $profesores = Profesor::all();
        $estudiantes = Estudiante::all();
        $usuarios = User::all();
        $profesoresConAcceso = User::whereNotNull('profesor_id')->pluck('profesor_id')->toArray();

        return view('usuarios.gestionar', compact(
            'profesores',
            'estudiantes',
            'usuarios',
            'profesoresConAcceso'
        ));
    }

    public function roles()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all()->groupBy('group');

        return view('usuarios.roles', compact('roles', 'permissions'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string|exists:roles,name',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'plain_password' => $request->password,
            'role' => $request->role,
        ]);

        return redirect()->route('users.gestionar')->with('success', 'Usuario creado exitosamente.');
    }

    public function grantAccess(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
        ]);

        $profesor = Profesor::findOrFail($request->profesor_id);

        $existing = User::where('profesor_id', $profesor->id)->first();
        if ($existing) {
            return redirect()->route('users.gestionar')->with('error', 'Este profesor ya tiene acceso al sistema.');
        }

        $firstName = Str::slug(mb_substr($profesor->nombre, 0, 1), '');
        $lastName = Str::slug($profesor->apellido, '');
        $systemEmail = strtolower($firstName . '.' . $lastName . '.' . $profesor->id . '@holaclase.cl');

        $password = Str::random(10);

        $user = User::create([
            'name' => $profesor->nombre . ' ' . $profesor->apellido,
            'email' => $systemEmail,
            'password' => $password,
            'plain_password' => $password,
            'role' => 'profesor',
            'profesor_id' => $profesor->id,
        ]);

        return redirect()->route('users.show', $user)->with('success', 'Acceso al sistema creado para ' . $profesor->nombre . ' ' . $profesor->apellido);
    }

    public function showUser(User $user)
    {
        $user->load('profesor');
        return view('usuarios.show', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $user->update([
            'password' => $request->password,
            'plain_password' => $request->password,
        ]);

        return redirect()->route('users.show', $user)->with('success', 'Contraseña actualizada exitosamente.');
    }

    public function notifyUser(Request $request, User $user)
    {
        $request->validate([
            'notify_email' => 'required|email',
        ]);

        $destinationEmail = $request->notify_email;

        try {
            Mail::raw(
                "Hola {$user->name},\n\n" .
                "Se te ha creado acceso al sistema HolaClase.\n\n" .
                "Tu usuario: {$user->email}\n" .
                "Tu contraseña: {$user->plain_password}\n\n" .
                "Ingresa en: " . config('app.url') . "\n\n" .
                "Saludos,\nAdministración HolaClase",
                function ($message) use ($destinationEmail, $user) {
                    $message->to($destinationEmail)
                            ->subject('Acceso al Sistema HolaClase - ' . $user->name);
                }
            );

            return redirect()->route('users.show', $user)->with('success', 'Notificación enviada a ' . $destinationEmail);
        } catch (\Exception $e) {
            return redirect()->route('users.show', $user)->with('error', 'Error al enviar notificación. Verifica la configuración de correo.');
        }
    }

    public function revokeAccess(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.gestionar')->with('error', 'No puedes revocar tu propio acceso.');
        }

        $user->delete();

        return redirect()->route('users.gestionar')->with('success', 'Acceso al sistema revocado.');
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => Str::slug($request->name),
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        if ($request->permissions) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('users.roles')->with('success', 'Rol "' . $role->display_name . '" creado exitosamente.');
    }

    public function updateRole(Request $request, Role $role)
    {
        if ($role->name === 'admin') {
            return redirect()->route('users.roles')->with('error', 'No se puede modificar el rol de administrador.');
        }

        $request->validate([
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->route('users.roles')->with('success', 'Rol "' . $role->display_name . '" actualizado.');
    }

    public function destroyRole(Role $role)
    {
        if (in_array($role->name, ['admin', 'profesor'])) {
            return redirect()->route('users.roles')->with('error', 'No se pueden eliminar roles del sistema.');
        }

        $usersWithRole = User::where('role', $role->name)->count();
        if ($usersWithRole > 0) {
            return redirect()->route('users.roles')->with('error', 'No se puede eliminar un rol con usuarios asignados.');
        }

        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('users.roles')->with('success', 'Rol eliminado exitosamente.');
    }
}
