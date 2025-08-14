<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Enums\StatusEnum;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'slug' => 'water-sanitation-systems',
                'title' => 'Water & Sanitation Systems',
                'short_description' => 'We bring decades of expertise in designing and implementing pressurized water networks and open channel sewer systems.',
                'quote' => 'Efficient water distribution and effective wastewater management',
                'description' => 'Our solutions are tailored for both residential and industrial developments, ensuring efficient water distribution and effective wastewater management. From concept to completion, we deliver systems that meet regulatory standards and community needs.',
                'features' => json_encode([
                    'Pressurized Water Networks',
                    'Open Channel Sewer Systems',
                    'Residential Development Solutions',
                    'Industrial Development Solutions',
                    'Regulatory Compliance',
                    'Community Needs Assessment'
                ]),
                'order' => 1,
                'status' => StatusEnum::active,
            ],
            [
                'slug' => 'bulk-water-supply-wastewater-treatment',
                'title' => 'Bulk Water Supply & Wastewater Treatment',
                'short_description' => 'We specialize in bulk water supply systems and outfall sewer designs, providing end-to-end solutions.',
                'quote' => 'End-to-end solutions from planning to construction supervision',
                'description' => 'We specialize in bulk water supply systems and outfall sewer designs, providing end-to-end solutions from planning to construction supervision. Our in-house team, supported by expert consultants, designs advanced water purification and wastewater treatment plants. We ensure sustainable, high-capacity infrastructure that supports growing populations and industrial demands.',
                'features' => json_encode([
                    'Bulk Water Supply Systems',
                    'Outfall Sewer Designs',
                    'Water Purification Plants',
                    'Wastewater Treatment Plants',
                    'Construction Supervision',
                    'High-Capacity Infrastructure'
                ]),
                'order' => 2,
                'status' => StatusEnum::active,
            ],
            [
                'slug' => 'comprehensive-water-infrastructure-services',
                'title' => 'Comprehensive Water Infrastructure Services',
                'short_description' => 'Our full-cycle engineering services cover all critical aspects of water management.',
                'quote' => 'Full-cycle engineering services for sustainable water management',
                'description' => 'Our full-cycle engineering services cover all critical aspects of water management: Bulk sewer and water planning – Strategic designs for large-scale urban and industrial needs. Reticulation systems – Precision-engineered networks for efficient water distribution. Wastewater treatment – Custom solutions for recycling and safe discharge. Non-revenue water management – Advanced techniques to reduce system losses. Pipeline upgrades – Modernizing aging infrastructure for improved performance. Every project is executed with a focus on sustainability, cost-efficiency and long-term reliability.',
                'features' => json_encode([
                    'Bulk Sewer and Water Planning',
                    'Reticulation Systems',
                    'Wastewater Treatment',
                    'Non-Revenue Water Management',
                    'Pipeline Upgrades',
                    'Strategic Urban Planning'
                ]),
                'order' => 3,
                'status' => StatusEnum::active,
            ],
            [
                'slug' => 'agricultural-irrigation-systems',
                'title' => 'Agricultural Irrigation Systems',
                'short_description' => 'We design and implement modern irrigation infrastructure including canals, ditches and drip irrigation systems.',
                'quote' => 'Optimizing water usage for agricultural operations',
                'description' => 'We design and implement modern irrigation infrastructure including canals, ditches and drip irrigation systems. Our solutions optimize water usage for agricultural operations, enhancing productivity while conserving resources. From small farms to large agribusinesses, we deliver water-efficient systems tailored to specific crop requirements.',
                'features' => json_encode([
                    'Canal Design & Construction',
                    'Ditch Systems',
                    'Drip Irrigation Systems',
                    'Water Usage Optimization',
                    'Agricultural Productivity Enhancement',
                    'Resource Conservation'
                ]),
                'order' => 4,
                'status' => StatusEnum::active,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }
    }
}
