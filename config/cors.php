<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Define the paths CORS should apply to.
    'allowed_methods' => ['*'], // Allow all HTTP methods.
    'allowed_origins' => ['http://localhost:3000'], // Allow only your React app's URL.
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Allow all headers.
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Set to true if your API uses cookies or session storage.
];
