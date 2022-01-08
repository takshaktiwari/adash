# Introduction to Adash

**Adash** is a admin panel package made for laravel on top of *Laravel Breeze*. It is a very simple setup for a quick start, with a saperate admin panel having user listing, edit and delete user, roles & permissions and change password. That's all. built with normal HTML and Bootstrap. 

## Installation

    composer require takshak/adash
Run above command and it will install **adash** along with **laravel breeze**.  
Update your *.env* file, provide database name, user and password. Execute command given below to install **adash admin panel**

    php artisan adash:install fresh
Or you can run just without `fresh` argument: `php artisan adash:install`. This will ask some questions like, if you want to migrate the fresh table or not, or you want to seed the tables or not.
Add following line to app\Http\Kernal.php in routeMiddleware array

    protected $routeMiddleware = [
        /* Add following line to the bottom */
        'gates' =>  \Takshak\Adash\Http\Middleware\GatesMiddleware::class,
    ];

This package comes with some default users, roles, and permission, which are inserted using seeders. There are three seeders are available: UserSeeder, RoleSeeder and PermissionSeeder. You need to publish the vendor and and run all seeders following steps need to be follow to seed, and you will get a default admin user  with email: *adash@gmail.com* and password: *123456*
