<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Exception Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in Exceptions thrown throughout the system.
    | Regardless where it is placed, a button can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'backend' => [
        'music' => [
            'albums' => [
                'create_error' => 'There was a problem creating this album. Please try again.',
                'update_error' => 'There was a problem updating this album. Please try again.',
                'delete_error' => 'There was a problem deleting this album. Please try again.',
                'title_error' => 'The album title has already been taken',
                'album_exists' => 'The album by this artist with this title  has already been created',
                'upload_error' => 'There was a problem uploading file to this album, please try again',
            ],

            'artists' => [
                'create_error' => 'There was a problem creating this artist. Please try again.',
                'update_error' => 'There was a problem updating this artist. Please try again.',
                'delete_error' => 'There was a problem deleting this artist. Please try again.',
                'name_error' => 'The artist name has already been taken',
                'slug_error' => 'The artist slug has already been taken',
                'upload_error' => 'There was a problem uploading file to this artist, please try again',
            ],

            'singles' => [
                'create_error' => 'There was a problem creating this single. Please try again.',
                'update_error' => 'There was a problem updating this single. Please try again.',
                'delete_error' => 'There was a problem deleting this single. Please try again.',
                'single_error' => 'The single name has already been taken',
                'slug_error' => 'The single slug has already been taken',
            ],

            'categories' => [
                'create_error' => 'There was a problem creating this category. Please try again.',
                'update_error' => 'There was a problem updating this category. Please try again.',
                'delete_error' => 'There was a problem deleting this category. Please try again.',
                'category_error' => 'The category name has already been taken',
                'slug_error' => 'The category slug has already been taken',
            ],

            'tracks' => [
                'create_error' => 'There was a problem creating this track. Please try again.',
                'update_error' => 'There was a problem updating this track. Please try again.',
                'delete_error' => 'There was a problem deleting this track. Please try again.',
                'title_error' => 'The track title has already been taken',
                'slug_error' => 'The track slug has already been taken',
                'upload_error' => 'The track could not be uploaded due to missing Artist or Title Tags, please fix those and upload again',
            ],
        ],
        
        'access' => [
            'roles' => [
                'already_exists'    => 'That role already exists. Please choose a different name.',
                'cant_delete_admin' => 'You can not delete the Administrator role.',
                'create_error'      => 'There was a problem creating this role. Please try again.',
                'delete_error'      => 'There was a problem deleting this role. Please try again.',
                'has_users'         => 'You can not delete a role with associated users.',
                'needs_permission'  => 'You must select at least one permission for this role.',
                'not_found'         => 'That role does not exist.',
                'update_error'      => 'There was a problem updating this role. Please try again.',
            ],

            'users' => [
                'already_confirmed'    => 'This user is already confirmed.',
                'cant_confirm' => 'There was a problem confirming the user account.',
                'cant_deactivate_self'  => 'You can not do that to yourself.',
                'cant_delete_admin'  => 'You can not delete the super administrator.',
                'cant_delete_self'      => 'You can not delete yourself.',
                'cant_delete_own_session' => 'You can not delete your own session.',
                'cant_restore'          => 'This user is not deleted so it can not be restored.',
                'cant_unconfirm_admin' => 'You can not un-confirm the super administrator.',
                'cant_unconfirm_self' => 'You can not un-confirm yourself.',
                'create_error'          => 'There was a problem creating this user. Please try again.',
                'delete_error'          => 'There was a problem deleting this user. Please try again.',
                'delete_first'          => 'This user must be deleted first before it can be destroyed permanently.',
                'email_error'           => 'That email address belongs to a different user.',
                'mark_error'            => 'There was a problem updating this user. Please try again.',
                'not_confirmed'            => 'This user is not confirmed.',
                'not_found'             => 'That user does not exist.',
                'restore_error'         => 'There was a problem restoring this user. Please try again.',
                'role_needed_create'    => 'You must choose at lease one role.',
                'role_needed'           => 'You must choose at least one role.',
                'session_wrong_driver'  => 'Your session driver must be set to database to use this feature.',
                'social_delete_error' => 'There was a problem removing the social account from the user.',
                'update_error'          => 'There was a problem updating this user. Please try again.',
                'update_password_error' => 'There was a problem changing this users password. Please try again.',
            ],
        ],
    ],

    'frontend' => [
        'auth' => [
            'confirmation' => [
                'already_confirmed' => 'Your account is already confirmed.',
                'confirm'           => 'Confirm your account!',
                'created_confirm'   => 'Your account was successfully created. We have sent you an e-mail to confirm your account.',
                'created_pending'   => 'Your account was successfully created and is pending approval. An e-mail will be sent when your account is approved.',
                'mismatch'          => 'Your confirmation code does not match.',
                'not_found'         => 'That confirmation code does not exist.',
                'pending'            => 'Your account is currently pending approval.',
                'resend'            => 'Your account is not confirmed. Please click the confirmation link in your e-mail, or <a href="'.route('frontend.auth.account.confirm.resend', ':user_id').'">click here</a> to resend the confirmation e-mail.',
                'success'           => 'Your account has been successfully confirmed!',
                'resent'            => 'A new confirmation e-mail has been sent to the address on file.',
            ],

            'deactivated' => 'Your account has been deactivated.',
            'email_taken' => 'That e-mail address is already taken.',

            'password' => [
                'change_mismatch' => 'That is not your old password.',
                'reset_problem' => 'There was a problem resetting your password. Please resend the password reset email.',
            ],

            'registration_disabled' => 'Registration is currently closed.',
        ],
    ],
];
