<?php
namespace xcesaralejandro\lti1p3\DataStructure;
use xcesaralejandro\lti1p3\Models\Context;
use xcesaralejandro\lti1p3\Models\Platform;
use xcesaralejandro\lti1p3\Models\ResourceLink;
use xcesaralejandro\lti1p3\Models\User;

class Instance 
{
    public Platform $platform;
    public Context $context;
    public ResourceLink $resourceLink;
    public User $user;
}
