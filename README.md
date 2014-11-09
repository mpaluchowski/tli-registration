# TLI Registration Form

A registration form for the Toastmasters Leadership Institute events, built on top of the PHP [Fat-Free Framework][fat-free-framework].

## Requirements

- PHP 5.4 or later with extensions
    + pdo_mysql
    + curl

## Installation

1. Copy all files to a web server directory.
2. Download the [Fat-Free Framework][fat-free-framework] and unpack its `/lib/` directory into the form's `/lib-fatfree/` directory.
3. Download the [PHP-JWT][php-jwt] library and copy its `/Authentication/JWT.php` file into the form's `/lib-php-jwt/` directory.
4. Create a MySQL database for the registrations and load the initiation scripts `/sql/structure.sql` and `/sql/data-init.sql`.
5. Copy `/app/defaults.ini` to `/app/config.ini` and fill in the configuration.
6. Copy `/public/.htaccess.default` to `/public/.htacceess` and set Apache Rewrite settings inside, as necessary.
7. Setup your virtual host to point to the `/public/` directory and make sure your PHP can access one directory above it, to be able to load the application classes.

## Credits

Building the TLI Registration Form quickly was only possible thanks to the relentless work of others, whose components became parts of this software:

* [Fat-Free Framework][fat-free-framework] by Bong Cosca
* [Bootstrap][bootstrap]
* [PHP-JWT][php-jwt]

## License

The TLI Registration Form is freely available and open-source, following the terms of the MIT License. For details of the license, please refer to [LICENSE](LICENSE).

[bootstrap]: http://getbootstrap.com/
[fat-free-framework]: http://fatfreeframework.com/
[php-jwt]: https://github.com/firebase/php-jwt
