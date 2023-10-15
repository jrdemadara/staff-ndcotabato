<?php

namespace App\Main;

use Illuminate\Support\Facades\Auth;

class TopMenu
{
    /**
     * List of top menu items.
     */
    public static function menu(): array
    {
        $menu = [
            'student-log' => [
                'icon' => 'User',
                'route_name' => 'student-log',
                'params' => [
                    'layout' => 'top-menu',
                ],
                'title' => 'Student Log',
            ],
            'section-log' => [
                'icon' => 'BoxSelect',
                'route_name' => 'section-log',
                'params' => [
                    'layout' => 'top-menu',
                ],
                'title' => 'Section Log',
            ],
            // Add other common menu items here...
        ];

        if (Auth::check()) {
            if (Auth::user()->is_admin === 1) {
                // Add admin-specific menu items here
                $menu['employee-log'] = [
                    'icon' => 'User',
                    'route_name' => 'employee-log',
                    'params' => [
                        'layout' => 'top-menu',
                    ],
                    'title' => 'Employee Log',
                ];

                $menu['employees-log'] = [
                    'icon' => 'Users',
                    'route_name' => 'employees-log',
                    'params' => [
                        'layout' => 'top-menu',
                    ],
                    'title' => 'Employees Log',
                ];
            }
        }

        $menu['sms-log'] = [
            'icon' => 'MessageCircle',
            'route_name' => 'sms-log',
            'params' => [
                'layout' => 'top-menu',
            ],
            'title' => 'SMS',
        ];

        return $menu;
    }
}
