## Introduction

Lti1p3 aims to facilitate LTI 1.3 protocol integration and provide simple integration to develop in laravel, currently the package has been successfully released on Canvas LMS and Moodle LMS.

This package does not yet have support for LTI Adventage, this means that you will not be able to use the name and role service or add qualifications

## Requirements

php >= 8.0

laravel >= 8.0


## Usage

#### 1.- Add the package to your project

`composer require xcesaralejandro/lti1p3`

#### 2.- Publish the provider

`php artisan vendor:publish --provider=xcesaralejandro\lti1p3\Providers\Lti1p3ServiceProvider --force`

#### 3.- Add your administrator credentials in your .ENV

````
LTI1P3_ADMIN_USERNAME=example@lti1p3.cl
LTI1P3_ADMIN_PASSWORD=lti1p3_admin
````

#### 4.- Complete the configuration file

After publishing our provider, we will have a file called lti1p3.php inside the config folder, there we will have to complete the configuration. Next I will leave the keys that are REQUIRED, the rest should be by default unless you understand that you are changing.

#####  VERIFY_HTTPS_CERTIFICATE
If true, will not allow self-signed https certificates.  

##### KID 
An identifier invented by you, this will be used to identify the public key in the Json Web Tokens (JWT)

##### PRIVATE_KEY 
A private RSA key

You can generate a new RSA private key of 2048 bit here: https://travistidwell.com/jsencrypt/demo/

  
  

## Are you ready to develop

The application will publish models and controller, you can start developing from there.

#### Important

I recommend you configure a local domain to develop, since when using JWT, the default domain (localhost), 127.0.0.1 or your current IP may not work correctly for signing.

# For register platforms

#### Login in tool panel

https://YOUR_APP_LARAVEL_DOMAIN/lti1p3/login

(The access credentials are those configured in your .ENV (Point 3))

#### Tool JWKS endpoint

https://YOUR_APP_LARAVEL_DOMAIN/api/jwks

#### Tool connection

All the urls (except jwks) required on the respective platform are:

https://YOUR_APP_LARAVEL_DOMAIN/lti/connect


### See the wiki to know how to use some things
