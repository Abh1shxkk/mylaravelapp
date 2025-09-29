<?php

return [
    // Minutes before a pending Stripe payment is considered expired for auto-fail
    'pending_expire_minutes' => (int) env('PENDING_EXPIRE_MINUTES', 30),
];
