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

Alternatively, you can build a guzzle-aws phar file and include the phar file
in your project:

    phing phar

Now you just need to include guzzle-aws.phar in your script.  The phar file
will take care of autoloading Guzzle\Service\Aws classes:

    <?php
    require_once 'guzzle.phar';
    require_once 'guzzle-aws.phar';

## Testing

Run the phing build script to configure guzzle-aws for PHPUnit testing:

    phing init

You will be prompted for the full path to your git clone of the main Guzzle
framework.

guzzle-aws uses PHPUnit to run unit tests.  Just type "phpunit" on the command line to run the tests.

### More information

- See https://github.com/guzzle/guzzle for more information about Guzzle, a PHP framework for building RESTful webservice clients.