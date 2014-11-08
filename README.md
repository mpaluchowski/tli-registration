# TLI Registration Form

A registration form for the Toastmasters Leadership Institute events, built on top of the PHP [Fat-Free Framework][fat-free-framework].

## Requirements

- PHP version minimum 5.4 with extensions
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

[fat-free-framework]: http://fatfreeframework.com/
[php-jwt]: https://github.com/firebase/php-jwt
