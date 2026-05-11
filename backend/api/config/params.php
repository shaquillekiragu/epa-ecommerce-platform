<?php

return [
    'adminEmail' => 'admin@example.com',
    /** Stripe secret key (sk_test_… / sk_live_…). Override in params-local.php — never commit secrets. */
    'stripe.secretKey' => '',
    /** Webhook signing secret (whsec_…). Optional for local dev if you use POST …/payments/sync instead. */
    'stripe.webhookSecret' => '',
];
