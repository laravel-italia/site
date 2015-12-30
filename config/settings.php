<?php

return [
    'publications' => [
        'articles_per_page' => env('ARTICLES_PER_PAGE'),
        'media_per_page' => env('MEDIA_PER_PAGE'),
    ],

    'user' => [
        'users_per_page' => env('USERS_PER_PAGE'),
    ],

    'forum' => [
        'threads_per_page' => env('THREADS_PER_PAGE')
    ]
];
