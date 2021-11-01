# GalleryCrud

An admin interface for [Laravel Backpack](laravelbackpack.com) to easily add, edit or remove Galleries.

It uses [Glide](http://glide.thephpleague.com/) and provides helper methods to serve the images in frontend blade templates.

## Install

1. In your terminal:

``` bash
$ composer require smartystudio/gallerycrud -W
```

2. If your Laravel version does not have package autodiscovery then add the service provider to your config/app.php file:

```php
Cviebrock\EloquentSluggable\ServiceProvider::class,
SmartyStudio\GalleryCrud\GalleryCRUDServiceProvider::class,
```

3. Publish the config file & run the migrations

```bash
$ php artisan vendor:publish --provider="SmartyStudio\GalleryCrud\GalleryCRUDServiceProvider" #publish config, view  and migration files
$ php artisan migrate #create the gallery table
```

4. Configuration of file storage in `config/filesystems.php`.

```php
'galleries' => [
    'driver' => 'local',
    'root' => storage_path('app/galleries'),
],
```

5. Configuration of file storage in config/elfinder.php:

```php
'roots' => [
    [
        'driver'        => 'GalleryCrudLocalFileSystem',         // driver for accessing file system (REQUIRED)
        'path'          => '../storage/app/galleries',           // path to files - relative to `public` (REQUIRED)
        'URL'           => '/galleries', // URL to files (REQUIRED)
        'accessControl' => 'Barryvdh\Elfinder\Elfinder::checkAccess',
        'autoload'      => true,
        'tmbPath'       => '',
        'tmbSize'       => 150,
        'tmbCrop'       => false,
        'tmbBgColor'    => '#000',
    ],
],
```

6. [Optional] Configuration of Glide image path in `config/smartystudio/gallerycrud.php`.

```php
'glide_path' => 'image',
```

7. [Optional] Add a menu item for it in resources/views/vendor/backpack/base/inc/sidebar.blade.php or menu.blade.php:

```html
<li class="nav-item"><a class="nav-link" href="{{ url(config('backpack.base.route_prefix', 'admin').'/gallery') }}"><i class="nav-icon la la-picture-o"></i><span>Galleries</span></a></li>
```

## How to use the package
This package relies heavily on the `elFinder` File Manager in Bakpack.

* First create a gallery
* Select some images or upload new ones
* Save the gallery and edit it again
* Now you can edit the captions for the selected images
* Helper methods are now available to load the images using Glide.
* `image_url` can be used where the images is from a `browse` field type so it may already include the disk path

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
// TODO
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email us instead of using the issue tracker.

## Credits

- Martin Nestorov - Web Developer @ Smarty Studio.
- All Contributors

## License

The SmartyStudio\GalleryCRUD is open-source software licensed under the MIT license.
