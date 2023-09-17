<?php
namespace xcesaralejandro\lti1p3\DataStructure;
use App\Models\LtiContext;
use App\Models\LtiPlatform;
use App\Models\LtiUser;
use xcesaralejandro\lti1p3\Classes\Message;
use App\Models\LtiDeployment;

class DeepLinkingInstance 
{
    public LtiPlatform $platform;
    public LtiDeployment $deployment;
    public LtiContext $context;
    public LtiUser $user;
    public Message $message;
}
