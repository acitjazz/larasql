<?php

use Illuminate\Support\Facades\Auth;

function navigation()
{
    if(Auth::guard('admin')->check()){

    return  [
        "title" => env('APP_NAME'),
        "logo"  => "/images/logo.svg",
        "link" => "/",
        "sections" => [
            [
                "title" => "",
                "menus" => [
                    [
                        "title" => "Dashboard",
                        "link" => route('dashboard.index'),
                        "icon" => "fa-table-columns",
                        "submenu" => [],
                        "method"=> 'get'
                    ],
                ]
            ],

            [
                "title" => "Pages",
                "menus" => [
                    [
                        "title" => "Home",
                        "link" => route('page.index',['type'=>'home']),
                        "icon" => "fa-house",
                        "submenu" => [],
                        "method"=> 'get'
                    ],
                    [
                        "title" => "Pages",
                        "link" => route('page.index',['type'=>'static']),
                        "icon" => "fa-file",
                        "submenu" => [],
                        "method"=> 'get'
                    ],
                ]
            ],

            [
                "title" => "Blog",
                "menus" => [
                    [
                        "title" => "Blog",
                        "link" => route('post.index',['type'=>'blog']),
                        "icon" => "fa-newspaper",
                        "submenu" => [],
                        "method"=> 'get'
                    ],
                    [
                        "title" => "Tag",
                        "link" => route('tag.index',['type'=>'blog']),
                        "icon" => "fa-cube",
                        "submenu" => [],
                        "method"=> 'get'
                    ],
                ]
            ],


            [
                "title" => "Navigation",
                "menus" => [
                    [
                        "title" => "Main Menu",
                        "link" => route('page.index',['type'=>'main-menu']),
                        "icon" => "fa-bars",
                        "submenu" => [],
                        "method"=> 'get'
                    ],
                    [
                        "title" => "Footer Menu",
                        "link" => route('page.index',['type'=>'footer-menu']),
                        "icon" => "fa-bars",
                        "submenu" => [],
                        "method"=> 'get'
                    ],
                ]
            ],
            [
                "title" => "",
                'class' => '',
                "menus" => [
                    [
                        "title" => "Logout",
                        "link" => route('admin.logout'),
                        "icon" => "fa-arrow-right-from-bracket",
                        "submenu" => [],
                        "method"=> 'post',
                        "as"=> 'button'
                    ],
                ]
            ],
        ]
        ];
    }
    return [
        "title" => env('APP_NAME'),
        "logo"  => "/images/logo.svg",
        "link" => route('home'),
        "sections" => [
            [
                "title" => "",
                'class' => '',
                "menus" => [
                    [
                        "title" => "Home",
                        "link" => route('home'),
                        "icon" => "fa-table-columns",
                        "submenu" => [],
                        "method"=> 'get',
                        'class'=> 'menu-dashboard'
                    ],
                ]
            ],

            [
                "title" => "",
                'class' => '',
                "menus" => [
                    [
                        "title" => "Logout",
                        "link" => route('logout'),
                        "icon" => "fa-arrow-right-from-bracket",
                        "submenu" => [],
                        "method"=> 'post',
                        "as"=> 'button'
                    ],
                ]
            ],
        ]
        ];
}
