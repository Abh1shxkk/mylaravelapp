<?php

return [
	'gateways' => [
		// Ensure env values like 'false' or '0' become proper booleans
		'razorpay' => filter_var(env('PAYMENT_RAZORPAY_ENABLED', true), FILTER_VALIDATE_BOOLEAN),
		'stripe'   => filter_var(env('PAYMENT_STRIPE_ENABLED', true), FILTER_VALIDATE_BOOLEAN),
	],
];


