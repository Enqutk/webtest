<?php

namespace App\Http\Controllers;

use App\Enums\EntityTypeEnum;
use App\Enums\StatusEnum;
use App\Models\Entity;
use App\Models\Hero;
use App\Models\Service;
use App\Models\Team;

class HomeController extends Controller
{
    public function index()
    {
        $heroes = Hero::where('status', StatusEnum::active)
            ->orderBy('order')
            ->get();

        $services = Service::activeOrdered()->get();

        $projects = Entity::where('status', StatusEnum::active)
            ->where('type', EntityTypeEnum::project)
            ->orderBy('order')
            ->take(6)
            ->get();

        $clients = Entity::where('status', StatusEnum::active)
            ->whereIn('type', [EntityTypeEnum::client, EntityTypeEnum::partner])
            ->orderBy('order')
            ->get();

        $team = Team::where('status', StatusEnum::active)
            ->orderBy('order')
            ->take(4)
            ->get();

        return view('index', compact('heroes', 'services', 'projects', 'clients', 'team'));
    }
}
