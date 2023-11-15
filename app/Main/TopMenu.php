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
            'student-profile' => [
                'icon' => 'User',
                'route_name' => 'student-profile.index',
                'params' => [
                    'layout' => 'top-menu',
                ],
                'title' => 'Student Profile',
            ],
            'student-log' => [
                'icon' => 'User',
                'route_name' => 'student-log.index',
                'params' => [
                    'layout' => 'top-menu',
                ],
                'title' => 'Student Log',
            ],
            // Add other common menu items here...
        ];

        if (Auth::check()) {
            if (Auth::user()->is_admin === 1) {
                // Add admin-specific menu items here
                $menu['employee-log'] = [
                    'icon' => 'User',
                    'route_name' => 'employee-log.index',
                    'params' => [
                        'layout' => 'top-menu',
                    ],
                    'title' => 'Employee Log',
                ];
            }
        }

        $menu['sms-log'] = [
            'icon' => 'MessageCircle',
            'route_name' => 'sms-log.index',
            'params' => [
                'layout' => 'top-menu',
            ],
            'title' => 'SMS',
        ];

        return $menu;
    }
}
