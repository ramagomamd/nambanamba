<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Menus Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in menu items throughout the system.
    | Regardless where it is placed, a menu item can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'backend' => [
        'settings' => [
            'all' => 'All Settings',
            'create' => 'Add A Setting',
            'edit' => 'Edit Setting',
            'management' => 'Setting Management',
            'view' => 'View Setting',
            'main' => 'Settings',
        ],
        
        'music' => [
            'title' => 'Music Management',

            'albums' => [
                'all' => 'All Albums',
                'create' => 'Add An Album',
                'edit' => 'Edit Album',
                'management' => 'Album Management',
                'view' => 'View Album',
                'main' => 'Albums',
            ],

            'artists' => [
                'all' => 'All Artist',
                'create' => 'Add An Artist',
                'edit' => 'Edit Artist',
                'management' => 'Artist Management',
                'view' => 'View Artist',
                'main' => 'Artists',
            ],

            'categories' => [
                'all' => 'All Categories',
                'create' => 'Add A Category',
                'edit' => 'Edit Category',
                'management' => 'Category Management',
                'view' => 'View Category',
                'main' => 'Categories',
            ],

            'genres' => [
                'all' => 'All Genres',
                'create' => 'Add A Genre',
                'edit' => 'Edit Genre',
                'management' => 'Genre Management',
                'view' => 'View Genre',
                'main' => 'Genres',
            ],

            'singles' => [
                'all' => 'All Singles',
                'create' => 'Add A Single',
                'edit' => 'Edit Single',
                'management' => 'Single Management',
                'view' => 'View Single',
                'main' => 'Singles',
            ],

            'tracks' => [
                'upload' => 'Upload Tracks',
                'all' => 'All Tracks',
                'create' => 'Add A Track',
                'edit' => 'Edit Track',
                'management' => 'Track Management',
                'view' => 'View Track',
                'main' => 'Tracks',
            ],
        ],
        
        'access' => [
            'title' => 'Access Management',

            'roles' => [
                'all'        => 'All Roles',
                'create'     => 'Create Role',
                'edit'       => 'Edit Role',
                'management' => 'Role Management',
                'main'       => 'Roles',
            ],

            'users' => [
                'all'             => 'All Users',
                'change-password' => 'Change Password',
                'create'          => 'Create User',
                'deactivated'     => 'Deactivated Users',
                'deleted'         => 'Deleted Users',
                'edit'            => 'Edit User',
                'main'            => 'Users',
                'view'            => 'View User',
            ],
        ],

        'log-viewer' => [
            'main'      => 'Log Viewer',
            'dashboard' => 'Dashboard',
            'logs'      => 'Logs',
        ],

        'sidebar' => [
            'dashboard' => 'Dashboard',
            'general'   => 'General',
            'system'    => 'System',
        ],
    ],

    'language-picker' => [
        'language' => 'Language',
        /*
         * Add the new language to this array.
         * The key should have the same language code as the folder name.
         * The string should be: 'Language-name-in-your-own-language (Language-name-in-English)'.
         * Be sure to add the new language in alphabetical order.
         */
        'langs' => [
            'ar'    => 'Arabic',
            'zh'    => 'Chinese Simplified',
            'zh-TW' => 'Chinese Traditional',
            'da'    => 'Danish',
            'de'    => 'German',
            'el'    => 'Greek',
            'en'    => 'English',
            'es'    => 'Spanish',
            'fr'    => 'French',
            'id'    => 'Indonesian',
            'it'    => 'Italian',
            'ja'    => 'Japanese',
            'nl'    => 'Dutch',
            'pt_BR' => 'Brazilian Portuguese',
            'ru'    => 'Russian',
            'sv'    => 'Swedish',
            'th'    => 'Thai',
            'tr'    => 'Turkish',
        ],
    ],
];
