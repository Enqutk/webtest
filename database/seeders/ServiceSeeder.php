<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'slug' => 'climate-smart-irrigation',
                'title' => 'Climate-Smart Irrigation',
                'short_description' => 'Solar drip, canal upgrades, and scheduling tools that stretch scarce water across seasons.',
                'quote' => 'More crop per drop — designed for East African farms',
                'description' => 'We design and supervise irrigation schemes for cooperatives, agribusinesses, and county programmes. From drip and sprinkler layouts to canal lining and pump sizing, every design is grounded in crop demand, soil data, and energy costs — including solar pumping where the grid is unreliable.',
                'features' => '<ul><li>Drip &amp; sprinkler system design</li><li>Canal lining and conveyance upgrades</li><li>Solar pumping packages</li><li>Crop water budgeting</li><li>Construction supervision</li><li>Farmer training &amp; O&amp;M manuals</li></ul>',
                'order' => 1,
                'status' => StatusEnum::active,
            ],
            [
                'slug' => 'rural-wash-systems',
                'title' => 'Rural WASH Systems',
                'short_description' => 'Safe water points, sanitation blocks, and last-mile reticulation for growing towns and villages.',
                'quote' => 'Reliable water and sanitation that communities can run',
                'description' => 'Our WASH practice covers borehole siting support, spring protection, gravity and pumped schemes, water kiosks, and institutional sanitation. We emphasise durable materials, clear O&amp;M roles, and designs that survive flood seasons and spare-part realities.',
                'features' => '<ul><li>Borehole &amp; spring schemes</li><li>Reticulation &amp; storage tanks</li><li>Water kiosks &amp; standpipes</li><li>School &amp; clinic sanitation</li><li>Water quality sampling plans</li><li>Community operator models</li></ul>',
                'order' => 2,
                'status' => StatusEnum::active,
            ],
            [
                'slug' => 'flood-drainage-resilience',
                'title' => 'Flood &amp; Drainage Resilience',
                'short_description' => 'Urban drains, wetland buffers, and early-warning layouts that keep roads and homes usable.',
                'quote' => 'Drainage that respects rivers — and people',
                'description' => 'We plan and design stormwater corridors, culverts, detention ponds, and nature-based buffers for towns along flood-prone rivers. Work includes hydrology reviews, alignment options, and phased capital plans that municipalities can fund over time.',
                'features' => '<ul><li>Stormwater masterplanning</li><li>Culvert &amp; channel design</li><li>Detention &amp; wetland buffers</li><li>Flood risk mapping support</li><li>Phased investment plans</li><li>Site supervision</li></ul>',
                'order' => 3,
                'status' => StatusEnum::active,
            ],
            [
                'slug' => 'water-resource-gis',
                'title' => 'Water Resource GIS',
                'short_description' => 'Maps, inventories, and decision dashboards for basins, utilities, and programme partners.',
                'quote' => 'See the system before you dig',
                'description' => 'We build spatial inventories of sources, networks, and customers; run simple demand models; and package maps that field teams actually use. Outputs support funding proposals, NRW targeting, and climate adaptation planning.',
                'features' => '<ul><li>Source &amp; network inventories</li><li>Demand &amp; coverage maps</li><li>Field data collection kits</li><li>NRW hotspot targeting</li><li>Proposal-ready map packs</li><li>Staff GIS coaching</li></ul>',
                'order' => 4,
                'status' => StatusEnum::active,
            ],
            [
                'slug' => 'solar-water-pumping',
                'title' => 'Solar Water Pumping',
                'short_description' => 'Off-grid and hybrid pumping for farms, institutions, and small utilities.',
                'quote' => 'Sun by day, water when you need it',
                'description' => 'We size solar arrays, pumps, controllers, and storage so systems match yield and demand — not brochure curves. Packages include hybrid grid options, theft-resistant layouts, and commissioning checklists for local technicians.',
                'features' => '<ul><li>Pump &amp; array sizing</li><li>Hybrid grid options</li><li>Tank &amp; head design</li><li>Security-minded layouts</li><li>Commissioning &amp; handover</li><li>Technician checklists</li></ul>',
                'order' => 5,
                'status' => StatusEnum::active,
            ],
            [
                'slug' => 'community-water-governance',
                'title' => 'Community Water Governance',
                'short_description' => 'Tariffs, operator training, and bylaws that keep schemes running after the ribbon-cutting.',
                'quote' => 'Hardware lasts when institutions do',
                'description' => 'Alongside engineering, we facilitate water committees, simple tariff models, spare-parts plans, and conflict-sensitive allocation rules. Ideal for NGO and county programmes that need schemes to survive beyond the grant cycle.',
                'features' => '<ul><li>Committee facilitation</li><li>Tariff &amp; bookkeeping basics</li><li>O&amp;M role charts</li><li>Spare-parts planning</li><li>Gender-inclusive bylaws</li><li>Post-construction coaching</li></ul>',
                'order' => 6,
                'status' => StatusEnum::active,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::query()->updateOrCreate(
                ['slug' => $serviceData['slug']],
                $serviceData
            );
        }
    }
}
