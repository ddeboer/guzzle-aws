Guzzle AWS Web Service Clients for PHP
======================================

Interact with various Amazon Web Services APIs using the Guzzle framework for
building RESTful web service clients in PHP.

- Amazon S3
- Amazon SQS
- Amazon SimpleDB
- Amazon MWS

## Installation

Add guzzle-aws to the src/Guzzle/Service/Aws directory of your Guzzle
installation:

    cd /path/to/guzzle
    git submodule add git://github.com/guzzle/guzzle-aws.git ./src/Guzzle/Service/Aws

You can now build a phar file containing guzzle-aws and the main guzzle framework:

    cd /path/to/guzzle/build
    phing phar

Now you just need to include guzzle.phar in your script.  The phar file
will take care of autoloading Guzzle classes:

    <?php
    require_once 'guzzle.phar';

## Testing

Run the phing build script to configure your project for PHPUnit testing:

    phing

You will be prompted for the full path to your git clone of the main Guzzle
framework.

### More information

- See https://github.com/guzzle/guzzle for more information about Guzzle, a PHP framework for building RESTful webservice clients.