<?php

return [
    'userManagement' => [
        'title'          => 'User Management',
        'title_singular' => 'User Management',
    ],
    'permission'     => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Title',
            'title_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'role'           => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'title'              => 'Title',
            'title_helper'       => '',
            'permissions'        => 'Permissions',
            'permissions_helper' => '',
            'color'              => 'Color',
            'color_helper'       => '',
            'level'              => 'Level',
            'level_helper'       => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'user'           => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Name',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'roles'                    => 'Roles',
            'roles_helper'             => '',
            'remember_token'           => 'Remember token',
            'remember_token_helper'    => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
            'rate'                     => 'Rate',
            'rate_helper'              => '',
        ],
    ],
    'bookingTime' => [
        'title'          => 'Booking Time',
        'title_singular' => 'Booking Time',
        'fields'         => [
            'id'                => 'ID',
            'user'              => 'User',
            'user_helper'       => '',
            'start_time'        => 'Start Time',
            'start_time_helper' => '',
            'end_time'          => 'End Time',
            'end_time_helper'   => '',
            'hours'             => 'Hours',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'availableBookingTime' => [
        'title'          => 'Available Booking',
        'title_singular' => 'Available Booking',
        'fields'         => [
            'id'                => 'ID',
            'start'             => 'Start',
            'start_helper'      => '',
            'end'               => 'End',
            'end_helper'        => '',
            'maximum'           => 'Maximum',
            'maximum_helper'    => '',
            'week_days'         => 'Week days',
            'week_days_helper'  => '',
            'role'              => 'Role',
            'role_helper'       => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'timesheets' => [
        'title'      => 'Timesheets',
        'check_in'   => 'Check-In',
        'check_out'  => 'Check-Out',
        'fields'     => [
            'id'                => 'ID',
            'date'              => 'Date',
            'user'              => 'User',
            'user_helper'       => '',
            'start_time'        => 'Start time',
            'start_time_helper' => '',
            'end_time'          => 'End time',
            'end_time_helper'   => '',
            'hours'             => 'Hours',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ]
    ],
    'specialTime' => [
        'title'          => 'Special Time',
        'title_singular' => 'Special Time',
        'fields'         => [
            'id'                    => 'ID',
            'date'                  => 'Date',
            'date_helper'           => '',
            'start'                 => 'Start',
            'start_helper'          => '',
            'end'                   => 'End',
            'end_helper'            => '',
            'reward_percent'        => 'Reward percent',
            'reward_percent_helper' => '',
            'role'              => 'Role',
            'role_helper'       => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ''
        ]
    ],
    'timekeeping' => [
        'title'   => 'Timekeeping',
        'fields'  => [
            'id'             => 'ID',
            'user'           => 'User',
            'role'           => 'Role',
            'start_time'     => 'Start time',
            'end_time'       => 'End time',
            'normal_time'    => 'Normal time (mins)',
            'special_time'   => 'Specical time (mins)',
            'total_time'     => 'Total time (mins)',
            'basic_salary'   => 'Basic salary',
            'reward_salary'  => 'Reward salary',
            'reward_percent' => 'Reward percent',
            'salary'         => 'Salary',
            'reward'         => 'Reward',
            'total'          => 'Total',
            'notes'          => 'Notes'
        ]
    ],
    'payroll' => [
        'title'  => 'Payroll',
        'fields' => [
            'id'                 => 'ID',
            'user'               => 'User',
            'total_normal_time'  => 'Total normal time (hrs)',
            'total_special_time' => 'Total special time (hrs)',
            'total_salary'       => 'Total salary'
        ]
    ],
    'configurations' => [
        'title'  => 'Configurations',
        'fields' => [
            'id'          => 'ID',
            'key'         => 'Key',
            'default'     => 'Default',
            'value'       => 'Value',
            'description' => 'Description'
        ]
    ]
];
