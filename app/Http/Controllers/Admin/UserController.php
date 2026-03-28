<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Handles HTTP endpoints for User Controller.
 */
class UserController extends Controller
{
    /**
     * Display a listing for the resource.
     *
     * @param  Request  $request  Parameter.
     */
    public function index(Request $request): View|JsonResponse
    {
        $this->ensureCanManageUsers();

        if ($request->ajax()) {
            $query = User::query()->with('roles');

            $table = datatables()->of($query)
                ->addColumn('role', function (User $user): string {
                    $roleName = $user->roles->pluck('name')->first();

                    if ($roleName === 'admin') {
                        return '<span class="badge bg-light-success text-success">'.__('admin.users.roles.admin').'</span>';
                    }

                    if ($roleName === 'blog editor') {
                        return '<span class="badge bg-light-warning text-warning">'.__('admin.users.roles.blog_editor').'</span>';
                    }

                    return '<span class="badge bg-light-secondary text-secondary">-</span>';
                })
                ->editColumn('created_at', function (User $user): string {
                    return $user->created_at?->format('d M Y H:i') ?? '-';
                })
                ->addColumn('actions', function (User $user): View {
                    $actions = [
                        [
                            'type' => 'link',
                            'classNames' => 'btn-sm btn-light-primary',
                            'icon' => 'fa fa-pen',
                            'link' => route('admin.users.edit', $user),
                            'attributes' => [
                                'data-bs-toggle' => 'tooltip',
                                'data-bs-placement' => 'top',
                                'title' => __('admin.common.edit'),
                                'aria-label' => __('admin.common.edit'),
                            ],
                        ],
                    ];

                    if (auth()->id() !== $user->id) {
                        $actions[] = [
                            'type' => 'destroy',
                            'link' => route('admin.users.destroy', $user),
                        ];
                    }

                    return view('admin.layouts.data-table-actions', compact('actions'));
                })
                ->rawColumns(['role', 'actions']);

            return $table->make(true);
        }

        return view('admin.users.index');
    }

    /**
     * Show the creation form for the resource.
     */
    public function create(): View
    {
        $this->ensureCanManageUsers();

        return view('admin.users.form', [
            'user' => new User,
            'availableRoles' => $this->availableRoles(),
        ]);
    }

    /**
     * Persist a newly created resource.

     *

     * @param  StoreUserRequest  $request  Parameter.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->ensureCanManageUsers();

        $validated = $request->validated();
        $role = $validated['role'];
        unset($validated['role']);

        $user = User::create($validated);
        $user->syncRoles([$role]);

        return redirect()->route('admin.users.index')->with('status', __('admin.users.messages.created'));
    }

    /**
     * Display the requested resource.

     *

     * @param  User  $user  Parameter.
     */
    public function show(User $user): void
    {
        abort(404);
    }

    /**
     * Show the edit form for the resource.

     *

     * @param  User  $user  Parameter.
     */
    public function edit(User $user): View
    {
        $this->ensureCanManageUsers();

        return view('admin.users.form', [
            'user' => $user,
            'availableRoles' => $this->availableRoles(),
        ]);
    }

    /**
     * Persist updates to the resource.

     *

     * @param UpdateUserRequest $request Parameter.

     * @param  User  $user  Parameter.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->ensureCanManageUsers();

        $validated = $request->validated();
        $role = $validated['role'];
        unset($validated['role']);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        if (auth()->id() === $user->id && $user->hasRole('admin') && $role !== 'admin') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('admin.users.messages.cannot_demote_self'));
        }

        $user->update($validated);
        $user->syncRoles([$role]);

        return redirect()->route('admin.users.index')->with('status', __('admin.users.messages.updated'));
    }

    /**
     * Delete the specified resource.

     *

     * @param  User  $user  Parameter.
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->ensureCanManageUsers();

        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', __('admin.users.messages.cannot_delete_self'));
        }

        if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
            return redirect()->route('admin.users.index')->with('error', __('admin.users.messages.cannot_delete_last_admin'));
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', __('admin.users.messages.deleted'));
    }

    /**
     * @return array<int, string>
     */
    private function availableRoles(): array
    {
        return ['admin', 'blog editor'];
    }

    private function ensureCanManageUsers(): void
    {
        abort_unless(auth()->user()?->can('manage users'), 403);
    }
}
