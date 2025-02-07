<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'counts' => [
                'sales' => 1080000,
                'courses' => 2456,
                'students' => 122456,
                'instructors' => 22786,
            ],

            'earningChartData' => [
                10,
                20,
                15,
                25,
                18,
                28,
                22,
                32,
                24,
                34,
                26,
                38
            ],
            'trafficChartData' => [
                'series' => [44, 55, 41],
                'labels' => ['Direct', 'Referral', 'Organic'],
            ],
            'popularInstructors' => [
                [
                    'avatar' => env('ASSET_URL') . '/images/avatar/avatar-1.jpg',
                    'name' => 'John Doe',
                    'courses' => 12,
                    'students' => 769,
                    'reviews' => 2140000,
                    'isOnline' => true,
                ],
                [
                    'avatar' => env('ASSET_URL') . '/images/avatar/avatar-2.jpg',
                    'name' => 'Surajit Mandal',
                    'courses' => 12,
                    'students' => 769,
                    'reviews' => 2140000,
                    'isOnline' => true,
                ]
            ],

            'recentCourses' => [
                [
                    'image' => env('ASSET_URL') . '/images/course/course-laravel.jpg',
                    'title' => "Revolutionize how you build the web...",
                    'instructor' => [
                        'avatar' => env('ASSET_URL') . '/images/avatar/avatar-7.jpg',
                        'name' => "Brooklyn Simmons",
                    ],
                ],
                [
                    'image' => env('ASSET_URL') . '/images/course/course-react.jpg',
                    'title' => "Revolutionize how you build the web...",
                    'instructor' => [
                        'avatar' => env('ASSET_URL') . '/images/avatar/avatar-6.jpg',
                        'name' => "Brooklyn Simmons",
                    ],
                ]
            ],
            'activities' => [
                [
                    'avatar' => env('ASSET_URL') . '/images/avatar/avatar-6.jpg',
                    'name' => "Dianna Smiley",
                    'activity' => "Just buy the courses “Build React Application Tutorial”",
                    'timeAgo' => "2m ago",
                    'status' => "online",
                ],
                [
                    'avatar' => env('ASSET_URL') . '/images/avatar/avatar-7.jpg',
                    'name' => "Surajit Mandal",
                    'activity' => "Just buy the courses “Build React Application Tutorial”",
                    'timeAgo' => "3m ago",
                    'status' => "offline",
                ],
            ],
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
