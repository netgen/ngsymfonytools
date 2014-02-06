# Netgen Symfony Tools extension installation instructions

## Requirements

   * eZ Publish 5.1+ running with Symfony stack

## Installation

### Unpack/unzip

Unpack the downloaded package into the `ezpublish_legacy/extension` directory of your eZ Publish installation.

### Activate extension

Activate the extension by using the admin interface ( Setup -> Extensions ) or by
prepending `ngsymfonytools` to `ActiveExtensions[]` in `ezpublish_legacy/settings/override/site.ini.append.php`:

    [ExtensionSettings]
    ActiveExtensions[]=ngsymfonytools

### Regenerate autoload array

Run the following from `ezpublish_legacy` folder

    php bin/php/ezpgenerateautoloads.php --extension

Or go to Setup -> Extensions and click the "Regenerate autoload arrays" button
