<?php

namespace App\Http\Middleware;

use App\Http\Resources\ProjectResource;
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

		//	Fetch all projects (shallow fetch) for the authenticated user, if they are logged in.
		$projects = Auth::check() ? Auth::user()->projects()->with([
			'characters', 'factions', 'locations'
			])->get() : null;

		//	Fetch the active project (deep fetch) for the authenticated user, if they are logged in and have an active project.
		$active_project = Auth::user() && $projects && Auth::user()->active_project
			? Auth::user()->projects()->with([
				'characters.location.region',
				'characters.factions.members',
				'characters.relationships',
				'factions.headquarters.region',
				'factions.ranks',
				'factions.members',
				'locations.characters',
				'locations.region',
				'regions.locations.characters',
				'customFields.options'
			])->get()->find(Auth::user()->active_project)
			: null;

        return array_merge(parent::share($request), [
			'appName' => config('app.name'),
			'csrfToken' => csrf_token(),
			'auth.user' => fn () => $request->user()
				? $request->user()->only('id', 'name', 'email', 'avatar')
				: null,
			'flash' => [
				'message' => fn () => $request->session()->get('message')
			],
			'projects' => $projects ? ProjectResource::collection($projects) : [],
			'active_project' => $active_project ? new ProjectResource($active_project) : []
		]);
    }
}
