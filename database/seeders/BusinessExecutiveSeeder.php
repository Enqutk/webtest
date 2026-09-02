<?php

namespace Database\Seeders;

use App\Enums\EntityTypeEnum;
use App\Enums\StatusEnum;
use App\Models\Entity;
use App\Models\Hero;
use App\Models\Organization;
use App\Models\OrganizationContact;
use App\Models\Service;
use App\Models\SocialRef;
use App\Models\Team;
use Illuminate\Database\Seeder;

class BusinessExecutiveSeeder extends Seeder
{
    public function run(): void
    {
        $orgData = [
            'title' => 'Alexander Sterling',
            'slug' => 'alexander-sterling',
            'tagline' => 'Managing Partner & Strategic Growth Advisory',
            'meta_description' => 'Alexander Sterling — Senior Board Advisor, Venture Capital Syndicate Leader, and Executive Strategist.',
            'po_box' => 'P.O. Box 784-00100',
            'address' => 'Executive Tower, Level 34, Financial Centre',
            'opening_hours' => [
                [
                    'days' => ['mon', 'tue', 'wed', 'thu', 'fri'],
                    'from' => '08:30:00',
                    'to' => '18:00:00',
                ],
            ],
            'status' => 'active',
            'theme' => [
                'bg' => '#090d16',
                'surface' => '#101726',
                'ink' => '#f8fafc',
                'muted' => '#94a3b8',
                'line' => '#1e293b',
                'accent' => '#c5a059',
                'accent_dark' => '#9e7d3b',
                'accent_soft' => 'rgba(197, 160, 89, 0.15)',
                'dark' => '#05080f',
                'font_display' => 'Cinzel',
                'font_body' => 'Outfit',
                'brand_font_family' => 'Cinzel',
                'brand_font_weight' => '700',
                'brand_letter_spacing' => '0.08em',
                'tagline_font_family' => 'Outfit',
                'tagline_font_style' => 'normal',
                'tagline_font_weight' => '500',
                'nav_font_family' => 'Outfit',
                'nav_font_weight' => '600',
                'nav_spacing' => '1.5rem',
                'image_shape' => 'squircle',
                'show_logo' => false,
                'show_brand_text' => true,
                'show_tagline' => true,
                'show_header_cta' => true,
                'header_cta_text' => 'Book Consultation',
                'show_address' => true,
                'show_po_box' => true,
                'show_opening_hours' => true,
                'show_email' => true,
                'show_phone' => true,
                'show_social_links' => true,
                'home_sections' => [
                    'hero' => [
                        'is_visible' => true,
                        'badge' => 'Senior Advisory · Venture Capital · Global Strategy',
                        'subtitle' => 'Executive Presence & Board Governance',
                        'title' => 'Architecting high-growth ventures and institutional capital strategies',
                        'description' => 'Over 18 years of cross-border investment leadership, guiding Fortune 500 boards, sovereign funds, and high-growth technology scaleups toward exponential valuation.',
                        'cta_text' => 'Schedule Advisory Consultation',
                        'cta_url' => '/contact',
                        'secondary_cta_text' => 'Track Record & Case Studies',
                        'secondary_cta_url' => '/portfolio',
                        'image_shape' => 'squircle',
                        'slides' => [
                            [
                                'eyebrow' => 'Venture & Growth Equity',
                                'title' => 'Accelerating enterprise valuation across emerging & frontier markets',
                                'description' => 'Deploying strategic growth capital and institutional governance to transform regional pioneers into global market leaders.',
                                'button_label' => 'View Track Record',
                                'button_url' => '/portfolio',
                                'image_shape' => 'squircle',
                                'is_visible' => true,
                            ],
                            [
                                'eyebrow' => 'M&A & Deal Structuring',
                                'title' => 'Cross-border mergers, buyouts, and syndicated liquidity exits',
                                'description' => 'Structured over $620M in private equity transactions, syndicated buyouts, and institutional co-investment mandates.',
                                'button_label' => 'Direct Executive Contact',
                                'button_url' => '/contact',
                                'image_shape' => 'squircle',
                                'is_visible' => true,
                            ],
                        ],
                    ],
                    'about' => [
                        'is_visible' => true,
                        'eyebrow' => 'Executive Profile & Philosophy',
                        'title' => 'Global strategic counsel for founders, family offices, and enterprise leaders',
                        'description' => "Alexander Sterling serves as a trusted advisor to founders, institutional investors, and sovereign wealth entities. Combining rigorous quantitative strategy with hands-on board governance, he empowers high-stakes leaders to navigate complex expansions, capital allocation, and digital transformation.",
                        'image_shape' => 'squircle',
                        'points' => [
                            [
                                'title' => 'Cross-Border Capital Syndication',
                                'description' => 'Direct access to institutional co-investors, private equity syndicates, and sovereign wealth mandates.',
                            ],
                            [
                                'title' => 'Board Governance & C-Suite Advisory',
                                'description' => 'Active independent director and executive strategist for high-growth tech scaleups and multinational boards.',
                            ],
                            [
                                'title' => 'Discreet Wealth & Asset Architecture',
                                'description' => 'Structuring multi-jurisdictional family office holdings, legacy transition frameworks, and direct co-investments.',
                            ],
                        ],
                    ],
                    'stats' => [
                        'is_visible' => true,
                        'eyebrow' => 'Career Milestones & Performance',
                        'title' => 'Quantifiable impact across global financial hubs',
                        'items' => [
                            [
                                'number' => '$620M+',
                                'label' => 'Capital Deployed & Syndicated',
                                'description' => 'Across growth equity, debt restructuring, and institutional private placements.',
                            ],
                            [
                                'number' => '42+',
                                'label' => 'Enterprise M&A Deals Closed',
                                'description' => 'Seamless cross-border buyouts, joint ventures, and strategic acquisitions.',
                            ],
                            [
                                'number' => '18+',
                                'label' => 'Years Executive Leadership',
                                'description' => 'Advising sovereign funds, tech scaleups, and Tier-1 institutional boards.',
                            ],
                            [
                                'number' => '100%',
                                'label' => 'Fiduciary Confidentiality',
                                'description' => 'Uncompromising discretion and tailored governance for elite principals.',
                            ],
                        ],
                    ],
                    'services' => [
                        'is_visible' => true,
                        'eyebrow' => 'Advisory Capabilities',
                        'title' => 'Bespoke executive services for high-stakes leadership',
                        'description' => 'Tailored engagements designed for high-growth founders, institutional boards, and private wealth principals.',
                    ],
                    'portfolio' => [
                        'is_visible' => true,
                        'eyebrow' => 'Transaction Track Record',
                        'title' => 'Selected key advisory & growth mandates',
                        'description' => 'Representative showcase of major funding rounds, market expansions, and board turnarounds.',
                        'image_shape' => 'squircle',
                    ],
                    'team' => [
                        'is_visible' => true,
                        'eyebrow' => 'Executive Office',
                        'title' => 'Principal & Key Advisory Partners',
                        'description' => 'Supported by specialized analysts and legal partners delivering bespoke turnaround and capital advisory.',
                        'cta_text' => 'Book Private Consultation',
                        'cta_url' => '/contact',
                        'image_shape' => 'squircle',
                    ],
                    'clients' => [
                        'is_visible' => true,
                        'eyebrow' => 'Institutional Network',
                        'title' => 'Trusted by leading sovereign and enterprise syndicates',
                        'description' => 'Collaborating with elite global private equity networks, venture partners, and multinational boards.',
                    ],
                    'cta' => [
                        'is_visible' => true,
                        'eyebrow' => 'Direct Executive Access',
                        'title' => 'Ready to architect your next strategic phase?',
                        'description' => 'Schedule a confidential executive discussion or tap NFC to save contact credentials directly to your mobile device.',
                        'button_text' => 'Schedule Confidential Call',
                        'button_url' => '/contact',
                        'secondary_button_text' => 'Direct WhatsApp',
                        'secondary_button_url' => 'https://wa.me/12125550199',
                    ],
                ],
            ],
        ];

        // 1. Create or Update the Executive Organization
        $org = Organization::updateOrCreate(['slug' => 'alexander-sterling'], $orgData);

        // 2. Executive Contacts
        OrganizationContact::where('organization_id', $org->id)->delete();
        foreach ([
            ['type' => 'email', 'value' => 'alexander@sterling-advisory.example'],
            ['type' => 'email', 'value' => 'office@sterling-advisory.example'],
            ['type' => 'phone', 'value' => '+1 (212) 555-0199'],
            ['type' => 'phone', 'value' => '+254 711 000 888'],
        ] as $c) {
            OrganizationContact::create([
                'organization_id' => $org->id,
                'type' => $c['type'],
                'value' => $c['value'],
                'status' => StatusEnum::active,
            ]);
        }

        // 3. Executive Social Links
        SocialRef::where('organization_id', $org->id)->delete();
        foreach ([
            ['title' => 'LinkedIn', 'icon_class' => 'bi bi-linkedin', 'link' => 'https://linkedin.com/'],
            ['title' => 'X (Twitter)', 'icon_class' => 'bi bi-twitter-x', 'link' => 'https://x.com/'],
            ['title' => 'WhatsApp', 'icon_class' => 'bi bi-whatsapp', 'link' => 'https://wa.me/12125550199'],
            ['title' => 'Calendar Booking', 'icon_class' => 'bi bi-calendar-event', 'link' => 'https://calendly.com/'],
        ] as $s) {
            SocialRef::create([
                'organization_id' => $org->id,
                'title' => $s['title'],
                'icon_class' => $s['icon_class'],
                'link' => $s['link'],
                'status' => StatusEnum::active,
            ]);
        }

        // 4. Executive Team / Office Members
        Team::where('organization_id', $org->id)->delete();
        $teamData = [
            [
                'first_name' => 'Alexander',
                'last_name' => 'Sterling',
                'title' => 'Managing Partner & Principal Advisor',
                'description' => '18+ years leading cross-border M&A, venture capital syndications, and board governance across North America, Europe, and Africa.',
                'founder' => true,
                'order' => 1,
            ],
            [
                'first_name' => 'Elena',
                'last_name' => 'Rostova',
                'title' => 'VP of Quantitative Strategy & Due Diligence',
                'description' => 'Former Goldman Sachs analyst specializing in valuation modeling, cross-border tax structures, and tech scaleup due diligence.',
                'founder' => false,
                'order' => 2,
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Mwangi',
                'title' => 'Partner, Regulatory & Institutional Deals',
                'description' => 'Specializes in sovereign public-private partnerships, energy transition mandates, and multinational regulatory clearance.',
                'founder' => false,
                'order' => 3,
            ],
        ];
        foreach ($teamData as $t) {
            Team::create(array_merge($t, [
                'organization_id' => $org->id,
                'status' => StatusEnum::active,
            ]));
        }

        // 5. Professional Services
        $services = [
            [
                'title' => 'Venture Capital & Growth Equity Syndication',
                'slug' => 'venture-growth-equity',
                'short_description' => 'Direct access to Tier-1 co-investors, institutional syndicate leadership, and structured Series A-C growth rounds.',
                'description' => 'We structure and lead institutional financing rounds for high-growth tech scaleups, delivering not just capital but operational leverage, board governance, and global distribution channels.',
                'features' => '<ul><li>Institutional syndicate formation and cap table optimization</li><li>Series A through C growth equity deal structuring</li><li>Sovereign wealth co-investment matching</li><li>Term sheet negotiation and investor relations governance</li></ul>',
                'quote' => 'Capital is a commodity. Strategic distribution and board execution determine category leadership.',
                'order' => 1,
            ],
            [
                'title' => 'Cross-Border M&A and Exit Strategy',
                'slug' => 'cross-border-ma',
                'short_description' => 'End-to-end strategic advisory for trade sales, corporate buyouts, dual-track exits, and cross-border integrations.',
                'description' => 'Guiding founders and shareholders through high-stakes mergers and acquisitions with rigorous valuation defense and flawless regulatory navigation.',
                'features' => '<ul><li>Comprehensive sell-side and buy-side advisory</li><li>Target acquisition scouting and confidential outreach</li><li>Multi-jurisdiction regulatory and competition clearance</li><li>Post-merger integration planning and synergy capture</li></ul>',
                'quote' => 'Maximizing enterprise value requires beginning the exit roadmap 24 months before transaction launch.',
                'order' => 2,
            ],
            [
                'title' => 'Board Governance & C-Suite Coaching',
                'slug' => 'board-governance-coaching',
                'short_description' => 'Independent board representation, executive committee advisory, and confidential C-Suite strategy sessions.',
                'description' => 'Serving as independent director and strategic sounding board for CEOs, founders, and investment committees navigating high-stakes inflection points.',
                'features' => '<ul><li>Independent director and board observer roles</li><li>C-Suite strategic performance alignment and OKR frameworks</li><li>Crisis management and shareholder dispute mediation</li><li>Executive compensation and equity incentive design</li></ul>',
                'quote' => 'Effective governance provides clarity and speed during rapid market transitions.',
                'order' => 3,
            ],
            [
                'title' => 'Private Wealth & Family Office Architecture',
                'slug' => 'family-office-architecture',
                'short_description' => 'Structuring multi-jurisdictional family holdings, direct private equity allocations, and legacy governance.',
                'description' => 'Bespoke advisory for ultra-high-net-worth principals and multi-generational family offices seeking uncorrelated direct investments and generational preservation.',
                'features' => '<ul><li>Multi-jurisdiction asset protection and holding structures</li><li>Direct co-investment deal flow and club deals</li><li>Generational succession and family charter governance</li><li>Philanthropic endowment setup and ESG impact strategy</li></ul>',
                'quote' => 'True legacy combines capital endurance with generational purpose.',
                'order' => 4,
            ],
        ];

        Service::where('organization_id', $org->id)
            ->orWhereIn('slug', collect($services)->pluck('slug'))
            ->forceDelete();
        foreach ($services as $s) {
            Service::create(array_merge($s, [
                'organization_id' => $org->id,
                'status' => StatusEnum::active,
            ]));
        }

        // 6. Portfolio / Key Transactions (Entities)
        Entity::where('organization_id', $org->id)->delete();
        $projects = [
            [
                'name' => 'FinTech Scaleup Series B ($42M)',
                'type' => EntityTypeEnum::project,
                'category' => 'Venture Capital',
                'description' => 'Advised founder and board on $42M Series B growth equity syndication, expanding footprint across 6 new international markets with a 4.2x valuation lift.',
                'order' => 1,
            ],
            [
                'name' => 'Cross-Border CleanTech Acquisition ($128M)',
                'type' => EntityTypeEnum::project,
                'category' => 'M&A Advisory',
                'description' => 'Structured competitive acquisition process resulting in premium strategic buyout with zero post-closing indemnity escrow.',
                'order' => 2,
            ],
            [
                'name' => 'Enterprise AI HealthTech Turnaround',
                'type' => EntityTypeEnum::project,
                'category' => 'Board Strategy',
                'description' => 'Appointed as executive board lead to re-engineer go-to-market channels and secure institutional follow-on commitment.',
                'order' => 3,
            ],
        ];
        foreach ($projects as $p) {
            Entity::create(array_merge($p, [
                'organization_id' => $org->id,
                'status' => StatusEnum::active,
            ]));
        }

        // 7. Institutional Partners & Client Logos (Entities)
        $clients = [
            [
                'name' => 'Apex Capital Partners',
                'type' => EntityTypeEnum::partner,
                'description' => 'Global Private Equity Syndicate',
                'order' => 1,
            ],
            [
                'name' => 'Sovereign Growth Fund',
                'type' => EntityTypeEnum::partner,
                'description' => 'Middle East Sovereign Co-Investment Mandate',
                'order' => 2,
            ],
            [
                'name' => 'Helios Venture Group',
                'type' => EntityTypeEnum::client,
                'description' => 'Tier-1 Early Stage Venture Syndicate',
                'order' => 3,
            ],
            [
                'name' => 'Vanguard Family Office',
                'type' => EntityTypeEnum::client,
                'description' => 'Multi-Generational Single Family Office',
                'order' => 4,
            ],
        ];
        foreach ($clients as $c) {
            Entity::create(array_merge($c, [
                'organization_id' => $org->id,
                'status' => StatusEnum::active,
            ]));
        }

        // 8. Hero Slides Table Record
        Hero::where('organization_id', $org->id)->delete();
        Hero::create([
            'organization_id' => $org->id,
            'subtitle' => 'Senior Advisory · Venture Capital · Global Strategy',
            'title' => 'Architecting high-growth ventures and sovereign capital strategies',
            'description' => 'Over 18 years of cross-border investment leadership, guiding Fortune 500 boards, sovereign funds, and high-growth technology scaleups toward exponential valuation.',
            'text_link' => 'Schedule Advisory Consultation',
            'button_link' => '/contact',
            'order' => 1,
            'status' => StatusEnum::active,
        ]);
        Hero::create([
            'organization_id' => $org->id,
            'subtitle' => 'M&A & Deal Structuring',
            'title' => 'Cross-border mergers, buyouts, and syndicated liquidity exits',
            'description' => 'Structured over $620M in private equity transactions, syndicated buyouts, and institutional co-investment mandates.',
            'text_link' => 'Direct Executive Contact',
            'button_link' => '/contact',
            'order' => 2,
            'status' => StatusEnum::active,
        ]);
    }
}
