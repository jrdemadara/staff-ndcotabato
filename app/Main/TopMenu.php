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
        $menu = [];

        if (Auth::check()) {
            if (Auth::user()->user_type === 'administrator') {
                // Add admin-specific menu items here
                $menu['student-profile'] = [
                    'icon' => 'User',
                    'route_name' => 'student-profile.index',
                    'params' => [
                        'layout' => 'top-menu',
                    ],
                    'title' => 'Student Profile',
                ];

                $menu['student-log'] = [
                    'icon' => 'User',
                    'route_name' => 'student-log.index',
                    'params' => [
                        'layout' => 'top-menu',
                    ],
                    'title' => 'Student Log',
                ];

                $menu['employee-log'] = [
                    'icon' => 'User',
                    'route_name' => 'employee-log.index',
                    'params' => [
                        'layout' => 'top-menu',
                    ],
                    'title' => 'Employee Log',
                ];

                $menu['sms-log'] = [
                    'icon' => 'MessageCircle',
                    'route_name' => 'sms-log.index',
                    'params' => [
                        'layout' => 'top-menu',
                    ],
                    'title' => 'SMS',
                ];

            } else if (Auth::user()->user_type === 'it') {
                $menu['student-log'] = [
                    'icon' => 'User',
                    'route_name' => 'student-log.index',
                    'params' => [
                        'layout' => 'top-menu',
                    ],
                    'title' => 'Student Log',
                ];

                $menu['employee-log'] = [
                    'icon' => 'User',
                    'route_name' => 'employee-log.index',
                    'params' => [
                        'layout' => 'top-menu',
                    ],
                    'title' => 'Employee Log',
                ];

            } else {
                $menu['section-log'] = [
                    'icon' => 'BookOpenCheck',
                    'route_name' => 'section-log.index',
                    'params' => [
                        'layout' => 'top-menu',
                    ],
                    'title' => 'Student Section Log',
                ];

            }
        }

        return $menu;
    }
}
