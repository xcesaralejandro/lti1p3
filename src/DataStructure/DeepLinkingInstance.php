<?php
namespace xcesaralejandro\lti1p3\DataStructure;
use App\Models\Context;
use App\Models\Platform;
use App\Models\User;
use xcesaralejandro\lti1p3\Classes\Message;
use xcesaralejandro\lti1p3\Models\Deployment;

class DeepLinkingInstance 
{
    public Platform $platform;
    public Deployment $deployment;
    public Context $context;
    public User $user;
    public Message $message;
}
