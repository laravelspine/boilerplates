<?php

declare(strict_types=1);

/**
 * CONTOH MANIFEST MODUL — kontrak frontend.
 *
 * Ini jembatan antara modul backend dan frontend (nextjs-spine):
 * - 'menu'    → item yang dirender Sidebar (padanan add_sidebar_menu_item)
 * - 'widgets' → widget yang dirender Dashboard per area (padanan get_dashboard_widgets)
 *
 * Core frontend TIDAK perlu tahu detail modul — cukup fetch manifest
 * lewat GET /api/v1/modules/{name}/manifest dan render apa adanya.
 *
 * @return array{menu: list<array{slug: string, label: string, icon: string, href: string, position: int}>, widgets: list<array{id: string, area: string, title: string, api: string}>}
 */
return [
    'menu' => [
        [
            'slug'     => 'sample',
            'label'    => 'Sample',
            'icon'     => '📦',
            'href'     => '/sample',
            'position' => 90,
        ],
    ],

    'widgets' => [
        [
            'id'    => 'sample-items',
            'area'  => 'right-4',
            'title' => 'Sample Items',
            'api'   => '/api/v1/sample',
        ],
    ],

    'detail_tabs' => [
        [
            'slug'     => 'overview',
            'label'    => 'Overview',
            'icon'     => '👁️',
            'api'      => '/api/v1/sample/{id}',
            'position' => 10,
        ],
        [
            'slug'     => 'activity',
            'label'    => 'Activity',
            'icon'     => '🕐',
            'api'      => '/api/v1/sample/{id}/activity-logs',
            'position' => 20,
        ],
    ],

    'settings' => [
        [
            'slug'     => 'sample',
            'label'    => 'Sample',
            'icon'     => '📦',
            'position' => 51,
            'fields'   => [
                [
                    'key'     => 'sample_prefix',
                    'label'   => 'Prefix',
                    'type'    => 'text',
                    'default' => 'SMP',
                ],
                [
                    'key'     => 'sample_max_items',
                    'label'   => 'Max items',
                    'type'    => 'number',
                    'default' => '100',
                ],
                [
                    'key'     => 'sample_notify',
                    'label'   => 'Notify on new item',
                    'type'    => 'checkbox',
                    'default' => '1',
                ],
            ],
        ],
    ],
];
