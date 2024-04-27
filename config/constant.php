<?php

return [
    'response' => [
        'registration' => [
            'success' => 'Successfully register',
        ],
        'login' => [
            'success' => 'Successfully login',
            'failed' => 'Invalid email or password',
        ],
        'appointment' => [
            'noAvailability' => 'No availability in this slot',
            'success' => 'Your appointment successfully booked',
            'cancelFailed' => 'This appointment id not belongs to your account',
            'alreadyCompleted' => 'This appointment is already completed',
            'noCancel' => 'You can not cancel this appointment within 24 hours of the appointment time.',
            'cancelSuccess' => 'You appointment successfully canceled.',
        ],
        'validationError' => 'Validation Error',
        'success' => 'success',
        'failed' => 'Something went wrong!',
        'exception' => 'Something went wrong!',
    ],
    'appointmentStatus' => [
        'booked'    => 1,
        'completed' => 2,
        'cancelled' => 3,
    ]
];
