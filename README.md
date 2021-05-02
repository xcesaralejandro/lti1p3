### Introduction

Lti1p3 aims to facilitate LTI 1.3 protocol integration and provide simple integration to develop in laravel, currently the package has been successfully released on Canvas LMS and Moodle LMS.

This package does not yet have support for LTI Adventage, this means that you will not be able to use the name and role service or add qualifications

### Requirements
php >= 8.0
laravel >= 8.0

### Installation and configuration

###### 1.- Add the package to your project

`composer require xcesaralejandro/lti1p3`

###### 2.- Publish the provider

`php artisan vendor:publish --provider=xcesaralejandro\lti1p3\Providers\Lti1p3ServiceProvider --force`

###### 3.- Complete the configuration file

After publishing our provider, we will have a file called lti1p3.php inside the config folder, there we will have to complete the configuration. Next I will leave the keys that are REQUIRED, the rest should be by default unless you understand that you are changing.

**VERIFY_HTTPS_CERTIFICATE** = If true, will not allow self-signed https certificates.

**KID** = An identifier invented by you, this will be used to identify the public key in the Json Web Tokens (JWT)

**PRIVATE_KEY** = A private RSA key

You can generate a new RSA private key of 2048 bit here: https://travistidwell.com/jsencrypt/demo/

### Are you ready to develop

The application will publish models and drivers, you can start developing from there.