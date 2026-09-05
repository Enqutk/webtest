<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EntityTypeEnum;
use App\Http\Controllers\Admin\Concerns\SavesImageFocus;
use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientPartnerController extends Controller
{
    use SavesImageFocus;

    public function quickStore(Request $request)
    {
        $currentOrg = Organization::resolveCurrent();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in([EntityTypeEnum::client->value, EntityTypeEnum::partner->value])],
            'link' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer'],
            'status' => ['nullable', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $validated['organization_id'] = $currentOrg->id;
        $validated['order'] = $validated['order'] ?? ((Entity::where('organization_id', $currentOrg->id)
            ->whereIn('type', [EntityTypeEnum::client, EntityTypeEnum::partner])
            ->max('order') ?? 0) + 1);
        $validated['status'] = $validated['status'] ?? 'active';

        $entity = Entity::create(array_merge($validated, $this->imageFocusFromRequest($request)));

        if ($request->hasFile('image')) {
            $entity->clearMediaCollection('image');
            $entity->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return back()->with('success', "'{$entity->name}' added!");
    }

    public function quickUpdate(Request $request, Entity $clientPartner)
    {
        abort_unless(in_array($clientPartner->type, [EntityTypeEnum::client, EntityTypeEnum::partner], true), 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in([EntityTypeEnum::client->value, EntityTypeEnum::partner->value])],
            'link' => ['nullable', 'string', 'max:255'],
            'order' => ['required', 'integer'],
            'status' => ['required', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $clientPartner->update(array_merge($validated, $this->imageFocusFromRequest($request)));

        if ($request->hasFile('image')) {
            $clientPartner->clearMediaCollection('image');
            $clientPartner->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return back()->with('success', "'{$clientPartner->name}' updated!");
    }

    public function destroy(Entity $clientPartner)
    {
        abort_unless(in_array($clientPartner->type, [EntityTypeEnum::client, EntityTypeEnum::partner], true), 404);

        $name = $clientPartner->name;
        $clientPartner->delete();

        return back()->with('success', "'{$name}' removed.");
    }
}
