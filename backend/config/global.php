<?php

return [
    'database' => [
        'driver' => 'Mysqli',
        'database' => 'blog',
        'username' => 'root',
        'password' => 'root',
        'host' => getenv("BLOG_HOST"),
        'charset' => 'utf8'
    ]
];
