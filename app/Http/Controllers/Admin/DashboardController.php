<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\Organization;
use App\Models\Page;
use App\Models\Service;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentOrg = Organization::resolveCurrent();
        $organizations = $user->organizations()->get();

        if ($organizations->isEmpty()) {
            $organizations = Organization::all();
        }

        $stats = [
            'servicesCount' => Service::query()->where('organization_id', $currentOrg->id)->count(),
            'teamCount' => Team::query()->where('organization_id', $currentOrg->id)->count(),
            'projectsCount' => Entity::query()->where('organization_id', $currentOrg->id)->count(),
            'pagesCount' => Page::query()->where('organization_id', $currentOrg->id)->count(),
            'orgsCount' => Organization::count(),
        ];

        $recentTeam = Team::query()->where('organization_id', $currentOrg->id)->orderBy('order')->take(4)->get();
        $recentServices = Service::query()->where('organization_id', $currentOrg->id)->orderBy('order')->take(4)->get();

        return view('admin.dashboard', compact('user', 'currentOrg', 'organizations', 'stats', 'recentTeam', 'recentServices'));
    }
}
