<?php

namespace App\Http\Controllers;

use App\Enums\EntityTypeEnum;
use App\Enums\StatusEnum;
use App\Models\Entity;
use App\Models\Organization;

class PortfolioController extends Controller
{
    public function index()
    {
        $currentOrg = Organization::resolvePublicCurrent();

        $projects = Entity::where('organization_id', $currentOrg->id)
            ->where('status', StatusEnum::active)
            ->where('type', EntityTypeEnum::project)
            ->with('media')
            ->orderBy('order')
            ->get();

        $categories = $projects
            ->pluck('category')
            ->filter()
            ->unique()
            ->values();

        return view('portfolio.index', compact('projects', 'categories', 'currentOrg'));
    }

    public function show(Entity $entity)
    {
        $currentOrg = Organization::resolvePublicCurrent();

        abort_unless(
            $entity->organization_id === $currentOrg->id &&
            $entity->status === StatusEnum::active &&
            $entity->type === EntityTypeEnum::project,
            404
        );

        $entity->load('media');

        $related = Entity::where('organization_id', $currentOrg->id)
            ->where('status', StatusEnum::active)
            ->where('type', EntityTypeEnum::project)
            ->where('id', '!=', $entity->id)
            ->with('media')
            ->orderBy('order')
            ->take(3)
            ->get();

        return view('portfolio.show', compact('entity', 'related', 'currentOrg'));
    }
}
