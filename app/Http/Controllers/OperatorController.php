<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class OperatorController extends Controller
{
    /**
     * Display the operators of the authenticated user's company.
     */
    public function index(): View
    {
        $operators = auth()->user()->company->users()
            ->role('Operario')
            ->orderBy('name')
            ->paginate(10);

        return view('operators.index', compact('operators'));
    }

    /**
     * Store a newly created operator in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $operator = auth()->user()->company->users()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $operator->assignRole('Operario');

        return back()->with('status', 'Operario creado.');
    }

    /**
     * Remove the specified operator from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        abort_unless($user->company_id === auth()->user()->company_id, 403);
        abort_if($user->is(auth()->user()), 403, 'No puedes eliminarte a ti mismo.');

        $user->delete();

        return back()->with('status', 'Operario eliminado.');
    }
}
