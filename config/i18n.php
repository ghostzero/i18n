<?php

return [

    'files' => explode(',', env('I18N_FILES', 'app')),

    'default' => env('I18N_SERVICE', 'simplelocalize'),

    'services' => [
        'simplelocalize' => [
            'token' => env('SIMPLELOCALIZE_TOKEN'),
        ],
    ],
];