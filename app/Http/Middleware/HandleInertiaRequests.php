<?php

namespace App\Http\Middleware;

use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserResource;
use App\Models\Character;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
		$user = Auth::user();

		//	Fetch all projects (shallow fetch) for the authenticated user, if they are logged in.
		$projects = Auth::check() ? $user->projects()->with([
			'banner', 'characters', 'factions', 'locations'
		])->get() : null;

		//	Fetch the active project (deep fetch) for the authenticated user, if they are logged in and have an active project.
		$activeProject = $user && $user->active_project
			? $user->projects()->with([
				// 'banner',
				'characters.location.banner',
				'characters.location.parent',
				'characters.factions.emblem',
				'characters.factions.members',
				'characters.banner',
				'characters.portrait',
				'characters.relationships',
				'characters.customFieldValues.customField',
				'factions.media',
				'factions.headquarters.banner',
				'factions.ranks',
				'factions.members.portrait',
				'locations.banner',
				'locations.characters.portrait',
				'locations.map',
				'locations.parent',
				'media',
				'customFields.options'
			])->find($user->active_project)
			: null;

        return array_merge(parent::share($request), [
			'appName' => config('app.name'),
			'csrfToken' => csrf_token(),
			// 'auth.user' => fn () => $request->user()
			// 	? $request->user()->only('id', 'name', 'email', 'avatar')
			// 	: null,
			'auth.user' => fn () => $request->user()
				? new UserResource($request->user())
				: null,
			'flash' => [
				'success' => fn () => $request->session()->get('success'),
            	'error'   => fn () => $request->session()->get('error'),
				'message' => fn () => $request->session()->get('message')
			],
			'projects' => $projects ? ProjectResource::collection($projects) : [],
			'activeProject' => $activeProject ? new ProjectResource($activeProject) : []
		]);
    }
}
