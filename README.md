
# Introduction to Adash

**Adash** is a admin panel package made for laravel on top of *Laravel Breeze*. It is a very simple setup for a quick start, with a saperate admin panel having user, roles & permissions, blog posts, pages, faqs and testimonials management. This package uses Bootstrap 4.x. 

Alertt: Alertt package has been integrated for any operation alert message, for any customization in this, please refer to takshak/alertt.

Imager: Takshak/Imager is integrated to generate seeds and resize and modify images at the time of upload images in defferent sections in the panel. This is also user to get default placeholder images and user avatars. For more information about this package, please refer to takshak/imager

## Installation
Update your *.env* file, provide database name, user and password. Execute command given below to install **adash admin panel**
`composer require takshak/adash`

Run following command to quick installation
`php artisan adash:install fresh`
This will prompt you to enter the names of modules which will be installed, eg: default, pages, blog.

To get more customizable options, you can run just without `fresh` argument: `php artisan adash:install`. This will ask some questions like, if you want to migrate the fresh table or not, or you want to seed the tables or not.
If you want to install some other module which you left during above process, just pass *module* argument with name of modules. *Module* option is a multiple choice option, you can add multiple module options in a single command, eg:
`composer require takshak/adash --module=blog --module=pages`

After installation you will get routes in admin.php file in routes folder, models and controller with their related trait and views. To override the properties / functionalities, define your own respective function in controller. This package comes with a route middleware 'gates', which will be registered in your app/Http/Kernel.php.

### Configurations
Add 'ASSET_URL' to .env file, which will point to pubic directory. 
public/assets: In this folder you will get all the static images, css, js and other files.
public/storage: You will get all you uploaded images here in different folders.


This package comes with some default users, roles, and permission, which are inserted using seeders. There seeders for all the modules. You will get a default admin user  with email: *adash@gmail.com* and password: *123456*
