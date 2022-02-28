
# Introduction to Adash

**Adash** is a admin panel package made for laravel on top of *Laravel Breeze*. It is a very simple setup for a quick start, with a separate admin panel having user, roles & permissions,  posts, pages, faqs and testimonials management. This package uses Bootstrap 4.x. 

## Installation
Update your *.env* file, provide database name, user and password. Execute command given below to install **adash admin panel**
`composer require takshak/adash`

Run following command to quick installation
`php artisan adash:install fresh`

By default default scaffold will be generated with default options, instead you can change your setting in configuration file `site.php` and run `php artisan adash:install` once again. This will ask some questions like, if you want to migrate the fresh table or not, or you want to seed the tables or not.

After installation you will get routes in admin.php file in routes folder, models and controller with their related trait and views. To override the properties / functionalities, define your own respective function in controller. This package comes with a route middleware `GatesMiddleware::class`, admin routes will be wrapped within this middleware.

### Configurations
Add `ASSET_URL` to *.env* file, which will point to pubic directory. 
public/assets: In this folder you will get all the static images, css, js and other files.

A `storage()` helper will be provided to get the url of publically stored images. If you want to change this url, you can set a property in *.env* file `STORAGE_URL`.

You can disable *install command* from *config/site.php* by setting *command* key to false. This will protect you by running the command file accidentally and replacing your existing files.

### Other packages being used

`**Alertt:**` Alertt package has been integrated for any operation alert message, for any customization in this, please refer to [takshak/alertt](https://github.com/takshaktiwari/alertt).

`**Imager:**` Takshak/Imager is integrated to generate seeds and resize and modify images at the time of upload images in different sections in the panel. This is also user to get default placeholder images and user avatars. For more information about this package, please refer to [takshak/imager](https://github.com/takshaktiwari/imager)

- - -
This package comes with some default users, roles, and permission, which are inserted using seeders. There seeders for all the modules. You will get a default admin user  with email: *adash@gmail.com* and password: *123456*
