# TLI Registration Form

A registration form for the Toastmasters Leadership Institute events, built on top of the PHP [Fat-Free Framework][fat-free-framework] with [Bootstrap][bootstrap].

## Features

- customizable form with all but the `email` field being optional, any number of fields supported
- form dependencies, allowing showing and hiding fields based on others' values
- list of clubs, allowing adding new custom entries
- client (HTML5-based) and customizable server-side validation, including guidance for people entering a duplicate email on how to proceed
- forms retrievable and viewable by a unique hash for simple security
- confirmation emails upon registration and later on request
- support for limited seat numbers and waiting list
- support for putting registrations on hold, pending further confirmation
- explicit registration statuses and guidance through the registration process
- customizable price calculation including real-time re-calculation on form edition and support for multiple currencies
- online payment integration
- customizable form processing
- administrative area with overview of all registrations, statistics
- administrative login via password or Google
- internationalization
- all layouts responsive
- mailer allows rerouting all emails to single inbox in testing, adding BCC to all outgoing email
- custom, friendly error pages
- optional SSL enforcement

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

## Customization

The form is designed and built to be generic wherever possible, so that it can easily be re-used for many TLIs and other events. There are, however, several components that need to be adjusted in order to tailor the form to a specific event:

- model
    + form processing, implementing the interface `/app/helpers/FormProcessor.php` and configured in `config.ini` at `form_processor`.
    + form validation, implementing the interface `/app/helpers/FormValidator.php` and configured in `config.ini` at `form_validator`.
    + __mandatory__ form rendering, implementing the interface `/app/helpers/FormRenderer` and configured in `config.ini` at `form_renderer`.
    + **mandatory** price calculation, implementing the interface `/app/models/PriceCalculator.php` and configured in `config.ini` at `form_price_calculator`.
- view
    + form designs in `/app/ui/registration/` and `/app/ui/administration/` with possible adjustments to CSS in `/public/css/`.
    + localizations in `/app/dict/`, mostly around form fields.
    + possible adjustments to code in `/public/js/`, if some fields are named differently or not available.

## Credits

Building the TLI Registration Form quickly was only possible thanks to the relentless work of others, whose components became parts of this software:

* [Fat-Free Framework][fat-free-framework] by Bong Cosca
* [Bootstrap][bootstrap]
* [PHP-JWT][php-jwt]
* [jQuery][jquery]
* [SASS][sass]

## License

The TLI Registration Form is freely available and open-source, following the terms of the MIT License. For details of the license, please refer to [LICENSE](LICENSE).

[bootstrap]: http://getbootstrap.com/
[fat-free-framework]: http://fatfreeframework.com/
[php-jwt]: https://github.com/firebase/php-jwt
[jquery]: http://jquery.com/
[sass]: http://sass-lang.com/
