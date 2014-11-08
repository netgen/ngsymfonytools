# Netgen Symfony Tools extension installation instructions

## Requirements

   * eZ Publish 5.1+ running with Symfony stack

## Installation

### Install through Composer

eZ Publish already comes bundled with the extension, so you can ofcourse skip this step if your
installation already has the extension. Otherwise, you can install the extension with the
following command:

    php composer.phar require netgen/ngsymfonytools:~1.1

### Activate extension

Activate the extension by using the admin interface ( Setup -> Extensions ) or by
prepending `ngsymfonytools` to `ActiveExtensions[]` in `ezpublish_legacy/settings/override/site.ini.append.php`:

```ini
[ExtensionSettings]
ActiveExtensions[]=ngsymfonytools
```

### Regenerate the legacy autoload array

Run the following from your installation root folder

    php ezpublish/console ezpublish:legacy:script bin/php/ezpgenerateautoloads.php

Or go to Setup -> Extensions in admin interface and click the "Regenerate autoload arrays" button
