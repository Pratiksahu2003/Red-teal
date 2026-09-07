<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Solution;
use Database\Seeders\Support\LongFormSeoContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ServiceSolutionSeeder extends Seeder
{
    /** @var array<int, string> */
    private const UNIQUE_IMAGE_URLS = [
        'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1544197150-361451702afe?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1550751827-4bd374c3d58b?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1473341304170-971dccb5ac71?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1535223396211-9c8dcf2b6d3a?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1555949963-aa79dcee981c?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?auto=format&fit=crop&w=1400&h=900&q=85',
        'https://images.unsplash.com/photo-1614064641938-3bbee52942c7?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1639322537504-6427a16b0ef8?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1504639725590-34d0984388bd?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=1400&h=900&q=80',
    ];

    public function run(): void
    {
        $this->seedImages();

        Service::query()->delete();
        Solution::query()->delete();

        foreach ($this->services() as $index => $service) {
            $num = $index + 1;
            $imagePath = "images/services/service-{$num}.jpg";
            $keywords = $service['keywords'];
            $tableRows = $service['table_rows'];
            unset($service['keywords'], $service['table_rows']);

            Service::create(array_merge($service, [
                'featured_image' => $imagePath,
                'og_image' => $imagePath,
                'full_description' => LongFormSeoContent::serviceBody(
                    $service['title'],
                    $service['category'],
                    $service['slug'],
                    $keywords,
                    $tableRows,
                ),
                'meta_title' => LongFormSeoContent::metaTitle($service['title']),
                'meta_description' => LongFormSeoContent::metaDescription($service['title'], 'service', $keywords),
            ]));
        }

        foreach ($this->solutions() as $index => $solution) {
            $num = $index + 1;
            $imagePath = "images/solutions/solution-{$num}.jpg";
            $keywords = $solution['keywords'];
            $tableRows = $solution['table_rows'];
            unset($solution['keywords'], $solution['table_rows']);

            Solution::create(array_merge($solution, [
                'featured_image' => $imagePath,
                'og_image' => $imagePath,
                'description' => LongFormSeoContent::solutionBody(
                    $solution['title'],
                    $solution['slug'],
                    $solution['benefits'],
                    $tableRows,
                    $keywords,
                ),
                'meta_title' => LongFormSeoContent::metaTitle($solution['title']),
                'meta_description' => LongFormSeoContent::metaDescription($solution['title'], 'solution', $keywords),
            ]));
        }
    }

    private function seedImages(bool $force = true): void
    {
        $serviceDir = public_path('images/services');
        $solutionDir = public_path('images/solutions');

        File::ensureDirectoryExists($serviceDir);
        File::ensureDirectoryExists($solutionDir);

        if ($force) {
            foreach (File::glob("{$serviceDir}/*.jpg") as $file) {
                File::delete($file);
            }
            foreach (File::glob("{$solutionDir}/*.jpg") as $file) {
                File::delete($file);
            }
        }

        $serviceSeeds = [
            'rednteal-svc-colocation-oslo-01',
            'rednteal-svc-cloud-exchange-02',
            'rednteal-svc-managed-infra-03',
            'rednteal-svc-dedicated-hosting-04',
            'rednteal-svc-ip-transit-05',
            'rednteal-svc-ddos-edge-06',
            'rednteal-svc-backup-dr-07',
            'rednteal-svc-remote-hands-08',
            'rednteal-svc-hpc-density-09',
            'rednteal-svc-compliance-audit-10',
            'rednteal-svc-sd-wan-fabric-11',
            'rednteal-svc-infra-consulting-12',
        ];

        $solutionSeeds = [
            'rednteal-sol-financial-01',
            'rednteal-sol-healthcare-02',
            'rednteal-sol-media-streaming-03',
            'rednteal-sol-government-04',
            'rednteal-sol-ecommerce-05',
            'rednteal-sol-gaming-06',
            'rednteal-sol-telecom-07',
            'rednteal-sol-energy-utilities-08',
            'rednteal-sol-education-09',
            'rednteal-sol-manufacturing-iot-10',
            'rednteal-sol-saas-scale-11',
            'rednteal-sol-research-hpc-12',
        ];

        $allUrls = self::UNIQUE_IMAGE_URLS;

        foreach ($serviceSeeds as $i => $seed) {
            $this->downloadUniqueImage($allUrls[$i], "{$serviceDir}/service-".($i + 1).'.jpg', $seed);
        }

        foreach ($solutionSeeds as $i => $seed) {
            $this->downloadUniqueImage($allUrls[$i + 12], "{$solutionDir}/solution-".($i + 1).'.jpg', $seed);
        }
    }

    private function downloadUniqueImage(string $url, string $destination, string $fallbackSeed): void
    {
        if (File::exists($destination) && File::size($destination) > 10_000) {
            return;
        }

        try {
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'header' => "User-Agent: RedNTeal-CMS-Seeder/1.0\r\n",
                    'timeout' => 60,
                    'ignore_errors' => true,
                ],
            ]);

            $body = @file_get_contents($url, false, $context);

            if ($body !== false && strlen($body) > 10_000) {
                File::put($destination, $body);

                return;
            }
        } catch (\Throwable) {
            // Fall back to local copy below.
        }

        $this->copyFallbackImage($fallbackSeed, $destination);
    }

    private function copyFallbackImage(string $seed, string $destination): void
    {
        $sources = [
            public_path('images/hero-slide-1.jpg'),
            public_path('images/hero-slide-2.jpg'),
            public_path('images/hero-slide-3.jpg'),
            public_path('images/hero-slide-4.jpg'),
            public_path('images/hero-slide-5.jpg'),
            public_path('images/hero-datacenter.jpg'),
            public_path('images/data-centre-facility.jpg'),
            public_path('images/about-technology.jpg'),
        ];

        $available = array_values(array_filter($sources, fn (string $path) => File::exists($path)));

        if ($available === []) {
            return;
        }

        $index = abs(crc32($seed)) % count($available);
        $source = $available[$index];

        if (! extension_loaded('gd')) {
            File::copy($source, $destination);

            return;
        }

        $type = exif_imagetype($source);
        $image = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($source),
            IMAGETYPE_PNG => imagecreatefrompng($source),
            IMAGETYPE_WEBP => imagecreatefromwebp($source),
            default => null,
        };

        if (! $image) {
            File::copy($source, $destination);

            return;
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $offsetX = abs(crc32($seed.'-x')) % max(1, $width - 400);
        $offsetY = abs(crc32($seed.'-y')) % max(1, $height - 300);
        $cropWidth = min(1200, $width - $offsetX);
        $cropHeight = min(800, $height - $offsetY);

        $cropped = imagecrop($image, [
            'x' => $offsetX,
            'y' => $offsetY,
            'width' => $cropWidth,
            'height' => $cropHeight,
        ]) ?: $image;

        imagejpeg($cropped, $destination, 88);
        imagedestroy($image);
        if ($cropped !== $image) {
            imagedestroy($cropped);
        }
    }

    /** @return array<int, array<string, mixed>> */
    private function services(): array
    {
        return [
            $this->serviceEntry(
                'Colocation',
                'colocation',
                'Hosting & Infrastructure',
                'server',
                'Secure Tier III+ rack space with flexible power, carrier-neutral connectivity, and 24/7 remote hands in Oslo and Stockholm.',
                ['colocation', 'Nordic data centre', 'Tier III+', 'rack space', 'renewable hosting'],
                [
                    ['Rack formats', 'Quarter, half, full, suite', 'Right-size without overcommit', 'Hot-aisle containment'],
                    ['Power density', 'Up to 50 kW / rack', 'Support AI and HPC growth', 'Liquid assist optional'],
                    ['Cross-connects', '42+ carriers on-site', 'Multi-cloud without transit', 'Meet-me room access'],
                    ['Remote hands', '24/7 smart hands', 'Faster incident resolution', 'Ticket portal + phone'],
                ],
                1,
            ),
            $this->serviceEntry(
                'Dedicated Server Hosting',
                'dedicated-server-hosting',
                'Hosting & Infrastructure',
                'hard-drive',
                'Bare-metal and dedicated clusters with guaranteed resources, custom hardware profiles, and private cage options.',
                ['dedicated servers', 'bare metal', 'private hosting', 'Nordic dedicated hosting'],
                [
                    ['Hardware profiles', 'Custom CPU, GPU, NVMe', 'Predictable performance', 'Vendor-neutral BOM'],
                    ['Network', '10/25/100 GbE options', 'Low-latency east-west', 'BGP sessions available'],
                    ['Security zones', 'Private cages & suites', 'Regulated workload isolation', 'Biometric access'],
                    ['Lifecycle', 'RMA & disposal services', 'Audit-ready asset tracking', 'WEEE-compliant recycling'],
                ],
                2,
            ),
            $this->serviceEntry(
                'High-Density HPC Hosting',
                'high-density-hpc-hosting',
                'Hosting & Infrastructure',
                'cpu',
                'Liquid-ready halls for AI training, simulation, and scientific compute up to 50 kW per rack with academic peering.',
                ['HPC hosting', 'AI infrastructure', 'high-density racks', 'liquid cooling'],
                [
                    ['Cooling', 'Hybrid air + liquid', 'Sustain dense GPU pods', 'ASHRAE-compliant inlet'],
                    ['Power', 'Dual-feed A+B', 'Eliminate single points', 'Busway monitoring'],
                    ['Peering', 'NREN & R&E links', 'Faster dataset movement', 'Scandinavian research grids'],
                    ['Scheduling', 'Batch-friendly design', 'Optimise capex per FLOP', 'Power capping APIs'],
                ],
                3,
            ),
            $this->serviceEntry(
                'Cloud Connectivity',
                'cloud-connectivity',
                'Cloud & Connectivity',
                'cloud',
                'Direct, low-latency on-ramps to AWS, Azure, Google Cloud, and Oracle with virtual routing and private exchanges.',
                ['cloud on-ramp', 'hybrid cloud', 'direct connect', 'multi-cloud networking'],
                [
                    ['On-ramps', 'AWS, Azure, GCP, OCI', 'Predictable cloud latency', 'Dedicated VLAN handoff'],
                    ['Latency', 'Sub-5 ms regional', 'Responsive hybrid apps', 'Measured monthly'],
                    ['Architecture', 'Cloud exchange fabric', 'Simpler BGP policies', 'Redundant paths'],
                    ['Billing', 'Port + cross-connect model', 'Transparent unit economics', 'No hidden transit'],
                ],
                4,
            ),
            $this->serviceEntry(
                'Internet Transit & IP Services',
                'internet-transit-ip-services',
                'Cloud & Connectivity',
                'globe',
                'Carrier-grade IP transit, BGP peering, and Anycast delivery with DDoS-scrubbing handoff options.',
                ['IP transit', 'BGP peering', 'Anycast', 'Nordic connectivity'],
                [
                    ['Transit', 'Multi-homed upstreams', 'Resilient global reach', 'SLA-backed packet delivery'],
                    ['BGP', 'Full table or partial', 'Traffic engineering control', 'Communities supported'],
                    ['IPv6', 'Dual-stack ready', 'Future-proof addressing', 'PI space guidance'],
                    ['DDoS handoff', 'Scrubbing partners', 'Protect edge services', 'Clean pipe options'],
                ],
                5,
            ),
            $this->serviceEntry(
                'SD-WAN & Private Networking',
                'sd-wan-private-networking',
                'Cloud & Connectivity',
                'network',
                'MPLS-alternative fabrics, encrypted site-to-site links, and SD-WAN hub colocation inside carrier-neutral facilities.',
                ['SD-WAN colocation', 'private networking', 'site-to-site encryption', 'WAN hub'],
                [
                    ['Topology', 'Hub-and-spoke or mesh', 'Match org structure', 'Active/active options'],
                    ['Encryption', 'MACsec / IPsec', 'Confidentiality in transit', 'HSM integration paths'],
                    ['Hubs', 'Oslo & Stockholm POPs', 'Regional aggregation', 'Cross-border EU paths'],
                    ['Observability', 'NetFlow export', 'Faster troubleshooting', 'SIEM-friendly feeds'],
                ],
                6,
            ),
            $this->serviceEntry(
                'Managed Infrastructure',
                'managed-infrastructure',
                'Managed Services',
                'settings',
                'End-to-end lifecycle management for hardware, OS patching, backups, monitoring, and incident response.',
                ['managed infrastructure', 'managed hosting', 'NOC services', '24/7 operations'],
                [
                    ['Scope', 'OS, firmware, backups', 'Reduce internal toil', 'Customisable runbooks'],
                    ['Monitoring', 'Infra + app probes', 'Earlier anomaly detection', 'PagerDuty integration'],
                    ['Patching', 'CAB-aligned windows', 'Lower vulnerability exposure', 'Rollback procedures'],
                    ['Incidents', 'Sev-based response', 'MTTR improvements', 'Post-incident reviews'],
                ],
                7,
            ),
            $this->serviceEntry(
                'Remote Hands & Smart Hands',
                'remote-hands-smart-hands',
                'Managed Services',
                'wrench',
                'On-site technicians for rack-and-stack, cable testing, media swaps, and emergency break-fix support.',
                ['remote hands', 'smart hands', 'data centre technicians', 'on-site support'],
                [
                    ['Tasks', 'Rack, cable, label', 'Accurate installs', 'Photo verification'],
                    ['SLA tiers', 'Standard & emergency', 'Match maintenance windows', '24/7 escalation'],
                    ['Access', 'Escorted vendor visits', 'Chain-of-custody', 'Visitor logging'],
                    ['Tooling', 'Certified test gear', 'Fewer repeat truck rolls', 'OTDR & copper certification'],
                ],
                8,
            ),
            $this->serviceEntry(
                'Backup & Disaster Recovery',
                'backup-disaster-recovery',
                'Managed Services',
                'database-backup',
                'Geo-diverse backup targets, immutable snapshots, and runbook-driven failover exercises.',
                ['disaster recovery', 'backup colocation', 'immutable backups', 'BCP hosting'],
                [
                    ['Targets', 'On-site + off-site', '3-2-1 alignment', 'Encrypted at rest'],
                    ['RPO/RTO', 'Contractual tiers', 'Business-aligned recovery', 'Quarterly drill option'],
                    ['Immutability', 'Snapshot locking', 'Ransomware resilience', 'Policy-based retention'],
                    ['Runbooks', 'Documented failover', 'Faster executive confidence', 'Cross-team tabletop'],
                ],
                9,
            ),
            $this->serviceEntry(
                'Cybersecurity & SOC Services',
                'cybersecurity-soc-services',
                'Security & Compliance',
                'shield-check',
                'Perimeter hardening, SIEM feed integration, vulnerability coordination, and 24/7 security operations support.',
                ['SOC services', 'cybersecurity', 'SIEM integration', 'security operations'],
                [
                    ['Monitoring', 'Facility + logical feeds', 'Unified incident view', 'CEF/JSON export'],
                    ['Hardening', 'Baseline templates', 'Reduce misconfiguration', 'CIS-aligned guides'],
                    ['Vuln mgmt', 'Scan coordination', 'Prioritised remediation', 'Change windows respected'],
                    ['Response', 'Playbook-driven', 'Containment faster', 'Forensic preservation'],
                ],
                10,
            ),
            $this->serviceEntry(
                'Compliance & Audit Readiness',
                'compliance-audit-readiness',
                'Security & Compliance',
                'file-check',
                'Control mapping, evidence packs, and auditor liaison for GDPR, ISO 27001, PCI DSS, and NIS2 programmes.',
                ['compliance hosting', 'audit readiness', 'GDPR infrastructure', 'ISO 27001 colocation'],
                [
                    ['Frameworks', 'ISO, PCI, NIS2, GDPR', 'Faster audit cycles', 'Pre-mapped controls'],
                    ['Evidence', 'Policy & test artefacts', 'Reduce questionnaire fatigue', 'Portal downloads'],
                    ['Data residency', 'EU/EEA facilities', 'Regulatory alignment', 'No unexpected transfers'],
                    ['Auditor support', 'Dedicated liaison', 'Shorter audit duration', 'Clarification SLAs'],
                ],
                11,
            ),
            $this->serviceEntry(
                'Infrastructure Consulting',
                'infrastructure-consulting',
                'Consulting',
                'compass',
                'Architecture reviews, TCO modelling, migration planning, and sustainability assessments for digital infrastructure.',
                ['infrastructure consulting', 'data centre strategy', 'migration planning', 'TCO analysis'],
                [
                    ['Discovery', 'Workshop-led', 'Shared problem definition', 'Stakeholder alignment'],
                    ['Modelling', '5-year TCO scenarios', 'Informed capex/opex', 'Sensitivity analysis'],
                    ['Migration', 'Phased cutover plans', 'Lower downtime risk', 'Rollback checkpoints'],
                    ['Sustainability', 'Carbon allocation', 'ESG reporting support', 'PUE & REC guidance'],
                ],
                12,
            ),
        ];
    }

    /** @return array<int, array<string, mixed>> */
    private function solutions(): array
    {
        return [
            $this->solutionEntry(
                'Financial Services',
                'financial-services',
                'landmark',
                'Low-latency, audit-ready infrastructure for banks, fintech, payments, and trading technology teams.',
                ['MiFID II ready hosting', 'Deterministic latency paths', 'Encrypted cross-connects', '24/7 SOC monitoring', 'PCI DSS alignment support'],
                ['financial services hosting', 'fintech colocation', 'trading infrastructure', 'regulated workloads'],
                [
                    ['Latency', '< 2 ms metro options', 'Support electronic trading', 'Diverse fibre paths'],
                    ['Compliance', 'PCI, GDPR, MiFID mapping', 'Shorter audits', 'Evidence libraries'],
                    ['Resilience', 'Active/active designs', 'Minimise settlement risk', 'Concurrent maintainability'],
                    ['Security', 'HSM-ready zones', 'Protect keys & HSMs', 'Dual-control procedures'],
                ],
                1,
            ),
            $this->solutionEntry(
                'Healthcare & Life Sciences',
                'healthcare-life-sciences',
                'heart-pulse',
                'HIPAA-aligned patterns, research data lakes, and imaging pipelines with strict access governance.',
                ['Clinical data residency', 'Research network peering', 'Immutable audit logs', 'BAA-ready documentation'],
                ['healthcare hosting', 'life sciences infrastructure', 'medical data centre', 'HIPAA patterns'],
                [
                    ['Data classes', 'PHI segmentation', 'Reduce blast radius', 'Zone-based access'],
                    ['Research', 'HPC burst capacity', 'Faster genomic pipelines', 'Academic peering'],
                    ['Imaging', 'High-throughput storage paths', 'Responsive PACS workloads', 'Low-latency fabric'],
                    ['Governance', 'Retention policies', 'Regulatory alignment', 'Legal hold support'],
                ],
                2,
            ),
            $this->solutionEntry(
                'Media & Streaming',
                'media-streaming',
                'play-circle',
                'Multi-gigabit delivery, CDN adjacency, and origin shielding for broadcasters and OTT platforms.',
                ['Multi-gigabit uplinks', 'CDN private interconnects', 'Origin shielding', 'Sustainable delivery at scale'],
                ['media hosting', 'streaming infrastructure', 'CDN peering', 'OTT platform colocation'],
                [
                    ['Bandwidth', '10–100 GbE scalable', 'Handle live spikes', 'Burstable contracts'],
                    ['CDN', 'Private peering', 'Lower rebuffer rates', 'Regional PoPs'],
                    ['Origin', 'Shield clusters', 'Protect upstreams', 'Cache-friendly design'],
                    ['Sustainability', 'Green energy matching', 'ESG-friendly streaming', 'Published carbon metrics'],
                ],
                3,
            ),
            $this->solutionEntry(
                'Government & Public Sector',
                'government-public-sector',
                'building-2',
                'Sovereign-ready hosting with EU data residency, supply-chain transparency, and incident coordination.',
                ['EU data residency', 'Supply-chain transparency', 'CERT coordination', 'High-assurance physical security'],
                ['government cloud', 'public sector hosting', 'sovereign data centre', 'EU residency'],
                [
                    ['Residency', 'EU-only processing', 'Meet sovereignty mandates', 'Documented flows'],
                    ['Procurement', 'Framework-friendly', 'Predictable commercials', 'Transparent SLAs'],
                    ['Security', 'Enhanced vetting', 'Protect citizen data', 'Air-gapped options'],
                    ['Continuity', 'Geo-diverse DR', 'Service citizen apps', 'Tested runbooks'],
                ],
                4,
            ),
            $this->solutionEntry(
                'E-commerce & Retail',
                'ecommerce-retail',
                'shopping-cart',
                'Elastic capacity for peak trading, payment isolation, and edge caching partnerships for global storefronts.',
                ['Peak traffic headroom', 'PCI zone segmentation', 'Fraud analytics proximity', 'Fast checkout paths'],
                ['ecommerce hosting', 'retail infrastructure', 'peak season capacity', 'PCI colocation'],
                [
                    ['Peaks', 'Reserved burst power', 'Survive Black Friday', 'Pre-event load tests'],
                    ['Payments', 'Isolated PCI enclaves', 'Reduce scope', 'Tokenisation friendly'],
                    ['Catalogue', 'Low-latency DB tiers', 'Snappy product pages', 'Read replica guidance'],
                    ['Global', 'CDN + origin design', 'International buyers', 'Multi-region DR'],
                ],
                5,
            ),
            $this->solutionEntry(
                'Gaming & Interactive Entertainment',
                'gaming-interactive-entertainment',
                'gamepad-2',
                'Low-latency game backends, matchmaking clusters, and anti-cheat telemetry pipelines.',
                ['Sub-20 ms player latency', 'GPU-dense racks', 'DDoS mitigation handoff', 'Global player matchmaking'],
                ['game server hosting', 'gaming infrastructure', 'low-latency hosting', 'GPU colocation'],
                [
                    ['Latency', 'Regional edge hubs', 'Fair competitive play', 'Anycast options'],
                    ['Compute', 'GPU pods', 'Rich physics & AI NPCs', 'Liquid-ready racks'],
                    ['Security', 'DDoS scrubbing', 'Protect matchmaking', 'Rate-limit integration'],
                    ['Live ops', 'Rolling deploy patterns', 'Minimal player disruption', 'Blue/green guidance'],
                ],
                6,
            ),
            $this->solutionEntry(
                'Telecommunications',
                'telecommunications',
                'radio',
                'NFV hosting, interconnect aggregation, and 5G core adjacency in carrier-neutral facilities.',
                ['NFV infrastructure', 'Interconnect aggregation', '5G core adjacency', 'Carrier-neutral meet-me'],
                ['telecom hosting', 'NFV colocation', '5G infrastructure', 'telco data centre'],
                [
                    ['NFV', 'High-throughput virtualisation', 'Elastic network functions', 'SR-IOV guidance'],
                    ['Interconnect', 'Dense cross-connects', 'Simplify peering', 'Meet-me automation'],
                    ['Timing', 'SyncE / PTP options', 'Stricter mobile SLAs', 'GPS antenna paths'],
                    ['Scale', 'Modular power growth', 'Support rollout waves', 'Reserved capacity'],
                ],
                7,
            ),
            $this->solutionEntry(
                'Energy & Utilities',
                'energy-utilities',
                'zap',
                'OT/IT convergence zones, SCADA isolation, and real-time analytics for grid and renewables operators.',
                ['OT/IT segmentation', 'SCADA isolation', 'Real-time analytics', 'NIS2-aligned controls'],
                ['energy sector hosting', 'utilities infrastructure', 'SCADA colocation', 'OT security'],
                [
                    ['Segmentation', 'OT DMZ patterns', 'Protect field assets', 'Unidirectional gateways'],
                    ['Analytics', 'Stream processing', 'Faster grid insights', 'Time-series DB tuning'],
                    ['Resilience', 'N+1 power & cooling', 'Maintain critical ops', 'Black-start planning'],
                    ['Compliance', 'NIS2 mapping', 'Regulator-ready docs', 'Incident reporting'],
                ],
                8,
            ),
            $this->solutionEntry(
                'Education & EdTech',
                'education-edtech',
                'graduation-cap',
                'Campus peering, LMS hosting, and research bursts with academic pricing and student privacy controls.',
                ['National research network peering', 'Student data privacy', 'Burst compute for exams', 'Academic pricing tiers'],
                ['education hosting', 'EdTech infrastructure', 'university colocation', 'research computing'],
                [
                    ['Peering', 'NREN connectivity', 'Fast research collaboration', 'Shared datasets'],
                    ['Privacy', 'FERPA/GDPR patterns', 'Protect student records', 'Role-based access'],
                    ['Exams', 'Burst capacity', 'Reliable online assessment', 'Isolated exam zones'],
                    ['EdTech', 'Multi-tenant guidance', 'Scale SaaS learners', 'API gateway colocation'],
                ],
                9,
            ),
            $this->solutionEntry(
                'Manufacturing & IoT',
                'manufacturing-iot',
                'factory',
                'Edge aggregation, digital twin workloads, and supply-chain integration with deterministic latency.',
                ['Edge aggregation gateways', 'Digital twin compute', 'Supply-chain integration', 'Deterministic factory latency'],
                ['manufacturing IoT', 'industrial hosting', 'digital twin infrastructure', 'edge colocation'],
                [
                    ['Edge', 'Plant-floor aggregation', 'Lower WAN costs', 'Local inference'],
                    ['Twins', 'Simulation clusters', 'Faster design iterations', 'GPU options'],
                    ['Integration', 'ERP/MES proximity', 'Reliable batch sync', 'Message bus patterns'],
                    ['Security', 'Zero-trust OT access', 'Reduce intrusion risk', 'Micro-segmentation'],
                ],
                10,
            ),
            $this->solutionEntry(
                'SaaS & Technology Scale-ups',
                'saas-technology-scaleups',
                'rocket',
                'Growth-ready colocation with predictable unit economics, rapid cross-connects, and investor-grade compliance.',
                ['Predictable unit economics', 'Rapid cross-connect provisioning', 'Investor-grade compliance packs', 'Scale without re-platforming'],
                ['SaaS hosting', 'scale-up infrastructure', 'B2B SaaS colocation', 'growth-ready hosting'],
                [
                    ['Growth', 'Reserved power ramps', 'Avoid emergency migrations', 'Modular suites'],
                    ['Economics', 'Transparent kW pricing', 'Forecast burn accurately', 'No hidden fees'],
                    ['Compliance', 'SOC 2 evidence', 'Accelerate enterprise sales', 'Customer security reviews'],
                    ['DevOps', 'CI/CD adjacent zones', 'Faster release cycles', 'GitOps-friendly network'],
                ],
                11,
            ),
            $this->solutionEntry(
                'Research & HPC',
                'research-hpc',
                'flask-conical',
                'Petascale-friendly density, R&E network fabrics, and green compute for universities and national labs.',
                ['Up to 50 kW per rack', 'Liquid cooling available', 'Academic network peering', 'Green energy for compute'],
                ['research computing', 'HPC colocation', 'scientific computing', 'AI research hosting'],
                [
                    ['Density', '50 kW racks', 'Train larger models', 'Liquid-ready halls'],
                    ['Fabric', 'HDR InfiniBand guidance', 'Lower MPI latency', 'Fat-tree designs'],
                    ['Data', 'Parallel filesystem tuning', 'Faster checkpointing', 'Burst storage tiers'],
                    ['Sustainability', '100% renewables', 'Publish carbon per job', 'Heat reuse options'],
                ],
                12,
            ),
        ];
    }

    /** @param  array<int, string>  $keywords
     * @param  array<int, array<int, string>>  $tableRows
     * @return array<string, mixed>
     */
    private function serviceEntry(
        string $title,
        string $slug,
        string $category,
        string $icon,
        string $shortDescription,
        array $keywords,
        array $tableRows,
        int $sortOrder,
    ): array {
        return [
            'title' => $title,
            'slug' => $slug,
            'category' => $category,
            'short_description' => $shortDescription,
            'icon' => $icon,
            'cta_text' => 'Request a Consultation',
            'cta_url' => '/contact',
            'sort_order' => $sortOrder,
            'status' => 'published',
            'keywords' => $keywords,
            'table_rows' => $tableRows,
        ];
    }

    /** @param  array<int, string>  $benefits
     * @param  array<int, string>  $keywords
     * @param  array<int, array<int, string>>  $tableRows
     * @return array<string, mixed>
     */
    private function solutionEntry(
        string $title,
        string $slug,
        string $icon,
        string $shortDescription,
        array $benefits,
        array $keywords,
        array $tableRows,
        int $sortOrder,
    ): array {
        return [
            'title' => $title,
            'slug' => $slug,
            'short_description' => $shortDescription,
            'icon' => $icon,
            'benefits' => $benefits,
            'cta_text' => 'Discuss Your Requirements',
            'cta_url' => '/contact',
            'sort_order' => $sortOrder,
            'status' => 'published',
            'keywords' => $keywords,
            'table_rows' => $tableRows,
        ];
    }
}
