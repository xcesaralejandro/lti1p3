<?php
namespace xcesaralejandro\lti1p3\DataStructure;
use App\Models\Context;
use App\Models\Platform;
use App\Models\ResourceLink;
use App\Models\User;
use xcesaralejandro\lti1p3\Classes\Message;
use App\Models\Deployment;

class ResourceLinkInstance 
{
    public Platform $platform;
    public Deployment $deployment;
    public Context $context;
    public ResourceLink $resourceLink;
    public User $user;
    public Message $message;
}
