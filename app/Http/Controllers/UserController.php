<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Profession;
use App\Skill;
use App\Sortable;
use App\User;
use App\UserFilter;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(UserFilter $userFilter, Sortable $sortable)
    {
        $users = User::query()
            ->when(request()->routeIs('users.trashed'), function ($q) {
                $q->onlyTrashed();
            })
            ->with('team', 'skills', 'profile.profession')
            ->when(request('team'), function ($query, $team) {
                if ($team == 'with_team') {
                    $query->has('team');
                } elseif ($team == 'without_team') {
                    $query->doesntHave('team');
                }
            })
            ->filterBy($userFilter, request()->only(['state', 'role', 'search', 'skills', 'from', 'to']))
            ->when(request('order'), function ($q) {
                $q->orderBy(request('order'), request('direction', 'asc'));
            }, function ($q) {
                $q->orderByDesc('created_at');
            })
            ->paginate();

        $users->appends($userFilter->valid());

        $sortable->setCurrentorder(request('order'), request('direction'));

        return view('users.index', [
            'users' => $users,
            'view' => request()->routeIs('users.trashed') ? 'trash' : 'index',
            'skills' => Skill::orderBy('name')->get(),
            'checkedSkills' => collect(request('skills')),
            'sortable' => $sortable,
        ]);
    }

    public function create()
    {
        return $this->form('users.create', new User);
    }

    public function store(CreateUserRequest $request)
    {
        $request->createUser();

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return $this->form('users.edit', $user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $request->updateUser($user);

        return redirect()->route('users.show', $user);
    }

    public function destroy($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->firstOrFail();

        $user->forceDelete();

        return redirect()->route('users.trashed');
    }

    public function trash(User $user)
    {
        $user->profile()->delete();
        $user->delete();

        return redirect()->route('users.index');
    }

    /**
     * @return array
     */
    public function form($view, User $user)
    {
        return view($view, [
            'professions' => Profession::orderBy('title', 'ASC')->get(),
            'skills' => Skill::orderBy('name', 'ASC')->get(),
            'user' => $user,
        ]);
    }
}
