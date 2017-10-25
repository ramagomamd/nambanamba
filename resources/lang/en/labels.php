<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Labels Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in labels throughout the system.
    | Regardless where it is placed, a label can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'general' => [
        'all'     => 'All',
        'yes'     => 'Yes',
        'no'      => 'No',
        'custom'  => 'Custom',
        'actions' => 'Actions',
        'active'  => 'Active',
        'buttons' => [
            'save'   => 'Save',
            'update' => 'Update',
        ],
        'hide'              => 'Hide',
        'inactive'          => 'Inactive',
        'none'              => 'None',
        'show'              => 'Show',
        'toggle_navigation' => 'Toggle Navigation',
    ],

    'backend' => [
        'settings' => [
                'owner' => 'Settings',
                'all' => 'All Settings',
                'create' => 'Add Setting',
                'edit' => 'Edit Setting',
                'management' => 'Settings Management',
                'view' => 'View Setting',
        ],

        'music' => [
            'albums' => [
                'owner' => 'Albums',
                'all' => 'All Albums',
                'create' => 'Add Album',
                'edit' => 'Edit Album',
                'management' => 'Albums Management',
                'view' => 'View Album',
                'no_categories' => 
                        'No Categories, create a categgory first before attempting to add an album',

                'table' => [
                    'id' => 'ID',
                    'title' => 'Title',
                    'slug' => 'Slug',
                    'description' => 'Description',
                    'tracks_number' => 'No. of Tracks',
                ],
            ],

            'artists' => [
                'owner' => 'Artists',
                'all' => 'All Artists',
                'create' => 'Add Artist',
                'edit' => 'Edit Artist',
                'management' => 'Artists Management',
                'view' => 'View Artist',
                'albums' => 'Albums',
                'singles' => 'Singles',
                'tracks' => 'Tracks',

                'table' => [
                    'id' => 'ID',
                    'name' => 'Name',
                    'slug' => 'Slug',
                    'bio' => 'Bio',
                ],
            ],

            'categories' => [
                'owner' => 'Categories',
                'all' => 'All Categories',
                'create' => 'Add Category',
                'edit' => 'Edit Category',
                'management' => 'Categories Management',
                'view' => 'View Category',
                'albums' => 'Albums',
                'singles' => 'Singles',

                'table' => [
                    'id' => 'ID',
                    'name' => 'Name',
                    'slug' => 'Slug',
                    'description' => 'Description',
                ],
            ],

            'genres' => [
                'owner' => 'Genres',
                'all' => 'All Genres',
                'create' => 'Add Genre',
                'edit' => 'Edit Genre',
                'management' => 'Genres Management',
                'view' => 'View Genre',

                'table' => [
                    'id' => 'ID',
                    'name' => 'Name',
                    'slug' => 'Slug',
                    'description' => 'Description',
                ],
            ],

            'singles' => [
                'owner' => 'Singles',
                'all' => 'All Singles',
                'create' => 'Add Single',
                'edit' => 'Edit Single',
                'management' => 'Singles Management',
                'view' => 'View Single',
                'categories' => 'Categories',
                'no_categories' => 'No Categories, create a categgory first before attempting to add a single',

                'table' => [
                    'id' => 'ID',
                    'title' => 'Title',
                    'categories' => 'Categories',
                    'genres' => 'Genres',
                ],
            ],

            'tracks' => [
                'owner' => 'Tracks',
                'all' => 'All Tracks',
                'create' => 'Add Track',
                'edit' => 'Edit Track',
                'management' => 'Tracks Management',
                'view' => 'View Track',
                'albums' => 'Track Album',
                'singles' => 'Track Single',
                'genres' => 'Genres',
                'categories' => 'Categories', 

                'table' => [
                    'id' => 'ID',
                    'title' => 'Title',
                    'slug' => 'Slug',
                    'duration' => 'Duration',
                    'comment' => 'Comment',
                    'album' => 'Album',
                ],
            ],
        ],
        
        'access' => [
            'roles' => [
                'create'     => 'Create Role',
                'edit'       => 'Edit Role',
                'management' => 'Role Management',

                'table' => [
                    'number_of_users' => 'Number of Users',
                    'permissions'     => 'Permissions',
                    'role'            => 'Role',
                    'sort'            => 'Sort',
                    'total'           => 'role total|roles total',
                ],
            ],

            'users' => [
                'active'              => 'Active Users',
                'all_permissions'     => 'All Permissions',
                'change_password'     => 'Change Password',
                'change_password_for' => 'Change Password for :user',
                'create'              => 'Create User',
                'deactivated'         => 'Deactivated Users',
                'deleted'             => 'Deleted Users',
                'edit'                => 'Edit User',
                'management'          => 'User Management',
                'no_permissions'      => 'No Permissions',
                'no_roles'            => 'No Roles to set.',
                'permissions'         => 'Permissions',

                'table' => [
                    'confirmed'      => 'Confirmed',
                    'created'        => 'Created',
                    'email'          => 'E-mail',
                    'id'             => 'ID',
                    'last_updated'   => 'Last Updated',
                    'name'           => 'Name',
                    'first_name'     => 'First Name',
                    'last_name'      => 'Last Name',
                    'no_deactivated' => 'No Deactivated Users',
                    'no_deleted'     => 'No Deleted Users',
                    'roles'          => 'Roles',
                    'social' => 'Social',
                    'total'          => 'user total|users total',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => 'Overview',
                        'history'  => 'History',
                    ],

                    'content' => [
                        'overview' => [
                            'avatar'       => 'Avatar',
                            'confirmed'    => 'Confirmed',
                            'created_at'   => 'Created At',
                            'deleted_at'   => 'Deleted At',
                            'email'        => 'E-mail',
                            'last_updated' => 'Last Updated',
                            'name'         => 'Name',
                            'first_name'   => 'First Name',
                            'last_name'    => 'Last Name',
                            'status'       => 'Status',
                        ],
                    ],
                ],

                'view' => 'View User',
            ],
        ],
    ],

    'frontend' => [

        'auth' => [
            'login_box_title'    => 'Login',
            'login_button'       => 'Login',
            'login_with'         => 'Login with :social_media',
            'register_box_title' => 'Register',
            'register_button'    => 'Register',
            'remember_me'        => 'Remember Me',
        ],

        'contact' => [
            'box_title' => 'Contact Us',
            'button' => 'Send Information',
        ],

        'passwords' => [
            'forgot_password'                 => 'Forgot Your Password?',
            'reset_password_box_title'        => 'Reset Password',
            'reset_password_button'           => 'Reset Password',
            'send_password_reset_link_button' => 'Send Password Reset Link',
        ],

        'macros' => [
            'country' => [
                'alpha'   => 'Country Alpha Codes',
                'alpha2'  => 'Country Alpha 2 Codes',
                'alpha3'  => 'Country Alpha 3 Codes',
                'numeric' => 'Country Numeric Codes',
            ],

            'macro_examples' => 'Macro Examples',

            'state' => [
                'mexico' => 'Mexico State List',
                'us'     => [
                    'us'       => 'US States',
                    'outlying' => 'US Outlying Territories',
                    'armed'    => 'US Armed Forces',
                ],
            ],

            'territories' => [
                'canada' => 'Canada Province & Territories List',
            ],

            'timezone' => 'Timezone',
        ],

        'user' => [
            'passwords' => [
                'change' => 'Change Password',
            ],

            'profile' => [
                'avatar'             => 'Avatar',
                'created_at'         => 'Created At',
                'edit_information'   => 'Edit Information',
                'email'              => 'E-mail',
                'last_updated'       => 'Last Updated',
                'name'               => 'Name',
                'first_name'         => 'First Name',
                'last_name'          => 'Last Name',
                'update_information' => 'Update Information',
            ],
        ],

    ],
];
