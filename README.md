# Introduction to Adash

**Adash** is a admin panel package made for laravel on top of *Laravel Breeze*. It is a very simple setup for a quick start, with a separate admin panel having user, roles & permissions,  posts, pages, faqs and testimonials management. This package uses Bootstrap 5.x. 

## Installation
Update your *.env* file, provide database name, user and password. Execute command given below to install **adash admin panel**

    composer require takshak/adash

Run following command to quick installation

    php artisan adash:install fresh

After installation you will get routes in admin.php file in routes folder, models and controller with their related trait and views. To override the properties / functionalities, define your own respective function in controller. This package comes with a route middleware `GatesMiddleware::class`, admin routes will be wrapped within this middleware.

### Configurations
Add `ASSET_URL` to *.env* file, which will point to pubic directory. 
public/assets: In this folder you will get all the static images, css, js and other files.

A `storage()` helper will be provided to get the url of publically stored images. If you want to change this url, you can set a property in *.env* file `STORAGE_URL`.

You can disable *install command* from *config/site.php* by setting *command* key to false. This will protect you by running the command file accidentally and replacing your existing files.

### Other packages being used

**`Alertt:`** Alertt package has been integrated for any operation alert message, for any customization in this, please refer to [takshak/alertt](https://github.com/takshaktiwari/alertt).

**`Imager:`** Takshak/Imager is integrated to generate seeds and resize and modify images at the time of upload images in different sections in the panel. This is also user to get default placeholder images and user avatars. For more information about this package, please refer to [takshak/imager](https://github.com/takshaktiwari/imager)


This package comes with some default users, roles, and permission, which are inserted using seeders. There seeders for all the modules. You will get a default admin user  with email: *adash@gmail.com* and password: *123456*
- - -

## Extra functionalities

There are some action button components which can be used to create action buttons

1. `x-admin.btns.action-show` : this can be used for a detail page. this comes with class btn-info, size small and with icon 'info-circle' as default
2. `x-admin.btns.action-edit` : this can be used for a edit action. this comes with class btn-success, size small and with icon 'edit' as default
3. `x-admin.btns.action-delete` : this can be used for delete action. It is a form with method 'POST' and 'DELETE'. this comes with class btn-danger, size small and with icon 'info-trash' as default
4. `x-admin.btns.action-btn` : this can be used for any general. this comes with class btn-primary, size small and with icon 'paper-plane' as default

Above all action buttons will have these parameters:

- _string_ **$url**: action url where user will be redirected on click
- _string_ **$permission** (optional)
- _string_ **$size** (optional) (default: 'sm')
- _string_ **$color** (optional) (eg: info, danger, primary, etc...)
- _string_ **$text** (optional): To show text on the button otherwise button will appear only with icon, without text
- _string_ **$icon** (optional) (eg. `<i class="fas fa-trash"></i>`): Button comes with default icon, but you can change it

## Extra functionalities

- **ReferrerMiddleware middleware:**  This middleware can be used to redirect from specific route to some other route. Both routes (form, to) should be passed in the route, eg. 

        route(
            'some.route', 
            [
                'refer' => [
                    // specify the route from where the application will be redirected
                    'refer_from'    => route('redirect.source'), 

                    // specify the destination route where to be redirected back
                    'refer_to'      => route('redirect.destination'),

                    // optional (checking the request method along with 'refer_from')
                    'method'        => 'GET' 
                ]
            ]
        );


**For Example:**
    
        route('some.route',  [ 
            'refer' => [ 
                'refer_from' => route('redirect.source'), 
                'refer_to' => route('redirect.destination'), 
                'method' => 'GET' 
            ] 
        ]);

- - -

## Queries Management

You can directly submit query forms from frontend to admin panel by posting forms on `route('queries.store')`. It will be stored on the database and an email will also be send to the mail defined in env file `MAIL_PRIMARY`. 

Possible input names are given below. All inputs are optional can will be defined in form if required:

- `name`: (string) You can store user's name.
- `email`: (string) You can store user's email.
- `mobile`: (string) Store user's mobile / phone.
- `subject`: (string) Subject of form or mail.
- `title`: (string) Can be used for title of the form.
- `content`: (text) Store message of content of form.
- `others`: (array) Other keys can also be specified via `name="others[input_name]"`.
- `files`: (array) You can put files specified via `name="files[resume]"`. Url of the file will be saved to database and included in mail.
- `redirect`: (string) Will be input type hidden and hold the url on which it will be redirected after submission.

## Settings Management

Most of the settings can be managed on the settings page. You can add your own custom settings, modify and delete but the default settings cannot be deleted. You can also see and manage the settings by the command line.

- `php artisan adash:settings`: list all the settings with all the details. To search and list only specific setting, you can pass the option `--search=`
- `php artisan adash:settings {action}`: possible values for the `action` argument is _create, update_ and _flush_. _create_ and _update_ argument do the same as the name specifies and _flush_ argument flushes the settings cache.

## Summernote editor

Summernote CDN is by default added to admin layout. Add class `summernote-editor` to apply the editor on any element to get the summernote with the default configurations.
