<?php

return [
    'install'    =>    [

        // Enable / Disable `adash:install` command
        'command'    =>    env('APP_DEBUG', true),

        /*
        | Packages
        |---------------------
        | These are third party packages other than `takshak/adash`.
        | There are several packages which can be used for improvements of project.
        |-------------------------------------
        | Some Packages: takshak/adash-blog, takshak/adash-slider, barryvdh/laravel-debugbar
        */
        'packages'    =>    [
            #'takshak/adash-blog',
            #'takshak/adash-slider',
            #'barryvdh/laravel-debugbar --dev'
        ],
    ],

    /*
    | Imager
    |---------------------
    | For configuration of package: `takshak/imager`.
    */
    'imager'    =>    [
        'picsum'    =>    [
            'enable_url'    =>    true,
        ],
        'placeholder'    =>    [
            'enable_url'    =>    true,
        ],
    ],
];
