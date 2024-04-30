## [Full documentation 🤓☝️](https://xcesaralejandro.github.io/lti1p3-docs/)

## Usage

#### 1.- Add the package to your project

`composer require xcesaralejandro/lti1p3`

#### 2.- Publish the provider

`php artisan vendor:publish --provider="xcesaralejandro\lti1p3\Providers\Lti1p3ServiceProvider" --force`

#### 3.- Add your administrator credentials in your .ENV

````
LTI1P3_ADMIN_USERNAME=example@lti1p3.cl
LTI1P3_ADMIN_PASSWORD=lti1p3_admin
````

#### 4.- Run migrations
````php artisan migrate````

#### 5.- Complete the configuration file

After publishing our provider, we will have a file called lti1p3.php inside the config folder, there we will have to complete the configuration. Next I will leave the keys that are REQUIRED, the rest should be by default unless you understand that you are changing.

#####  VERIFY_HTTPS_CERTIFICATE
If true, will not allow self-signed https certificates.  

##### KID 
An identifier invented by you, this will be used to identify the public key in the Json Web Tokens (JWT)

##### PRIVATE_KEY 
A private RSA key

You can generate a new RSA private key of 2048 bit here: https://travistidwell.com/jsencrypt/demo/

  
## Note  
If you are using some reversible proxy it is possible that the package styles published by the provider will try to load with http instead of https, which produces an error. To fix the problem you can force the https scheme in your AppServiceProvider, adding ````\URL::forceScheme('https'); ```` in the boot method.

#### Important

I recommend you configure a local domain to develop, since when using JWT, the default domain (localhost), 127.0.0.1 or your current IP may not work correctly for signing.

## Get started with development

The application will publish models and controller, you can start developing from there.

After registering a platform (LMS), the package will be in charge of synchronizing and updating all the data coming from the LMS or creating it if it does not exist. With this data we refer to the information of the platform, course, resource, user, etc.

Once the launch has concluded, the LtiController is called in its different methods depending on the final state of the flow.

````
<?php

namespace App\Http\Controllers;

use xcesaralejandro\lti1p3\Http\Controllers\Lti1p3Controller;

class LtiController extends Lti1p3Controller {

    /*

        Important!
        Consider that an LTI can be added on multiple sides, 
        sometimes your LTI can receive LtiResourceLinkRequest and LtiDeepLinkingRequest triggers

    */

    public function onResourceLinkRequest(string $instance_id) : mixed {
        return parent::onResourceLinkRequest($instance_id);
        // Do something, here it is not necessary to call the parent function,
        // it is only to maintain the example functionality

        // This method is called when the lti launch is of type LtiResourceLinkRequest
        // You can read about it here: http://www.imsglobal.org/spec/lti/v1p3/#resource-link-launch-request-message

        // In human words, it is the launch of the LTI after doing the validations behind the scenes and the synchronization 
        // of the data that arrives from the LMS with the local platform (The one that you must now start developing). 
        // Sometimes this launch can be skipped by a custom redirect if you defined it in the LMS or it is a LtiDeepLinkingRequest.
    }

    public function onDeepLinkingRequest(string $instance_id) : mixed {
        return parent::onDeepLinkingRequest($instance_id);
        // Do something, here it is not necessary to call the parent function,
        // it is only to maintain the example functionality

        // This method is called when the lti launch is of type LtiDeepLinkingRequest
        // You can read about it here: https://www.imsglobal.org/spec/lti-dl/v2p0#overview

        // In human words, it is the launch of the LTI when it comes to DeepLinking. This, depending on the location where you add your LTI, 
        // allows you to generate custom resources, return tasks, among other things.
        // I recommend reading the specification because to date I haven't tested everything it allows (UPS!).

        // In such a launch you must reply back to the LMS with a DeepLinking message to end the cycle.
        // You can browse the original model to review how the example works.
    }

    public function onError(mixed $exception = null) : mixed {
        return parent::onError($exception);
        // Do something, here it is not necessary to call the parent function,
        // it is only to maintain the example functionality

        // The onError method will be thrown when an invalid connection is attempted, 
        // something goes wrong in the launch process (LMS-LTI). If it is the latter case, 
        // it is most likely due to some problem with the configuration.
        
        // If you're sure you've set everything up correctly and you're still getting errors, 
        // open a github bug, I'll be happy to cry with you for not understanding what's wrong.
    }
}

````



# For register platforms

#### Login in tool panel

https://YOUR_APP_LARAVEL_DOMAIN/lti1p3/login

(The access credentials are those configured in your .ENV (Point 3))

#### Tool JWKS endpoint

https://YOUR_APP_LARAVEL_DOMAIN/api/jwks

#### Tool connection

All the urls (except jwks) required on the respective platform are:

https://YOUR_APP_LARAVEL_DOMAIN/lti1p3/connect

