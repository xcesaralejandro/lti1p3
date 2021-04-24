<?php
namespace xcesaralejandro\lti1p3\DataStructure;

class Claims 
{
    public string $message_type;
    public string $version;
    public object $resource_link;
    public string $deployment_id;
    public string $target_link_uri;
    public object $lis;
    public object $context;
    public object $tool_platform;
    public object $launch_presentation;
    public array $roles;
    public object $custom;
}
