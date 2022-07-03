<?php

return [
    'app_name' => 'LTI 1.3 Template',
    'login_title' => 'Login',
    'login_email_placeholder' => 'Email',
    'login_password_placeholder' => 'Password',
    'login_remember_me' => 'Remember the session',
    'login_button' => 'sign in',
    'login_attemp_failed' => 'Bad login',
    'navbar_add_platform' => 'New platform',
    'navbar_list_platforms' => 'List platforms',
    'navbar_logout' => 'logout',
    'platform_local_name_label' => 'Platform name',
    'platform_issuer_id_label' => 'Platform id',
    'platform_client_id_label' => 'Client id',
    'platform_lti_advantage_token_url_label' => 'LTI Advantage token url',
    'platform_authorization_url_label' => 'Authorization url',
    'platform_authentication_url_label' => 'Authentication url',
    'platform_json_webkey_url_label' => 'Json webkey url',
    'platform_signature_method_label' => 'Signature method',
    'platform_deployment_id_autoregister_label' => 'Auto register deployments',
    'platform_deployments_count_label' => 'Deployments count',
    'platform_add_new_deployment_button' => 'Manage deployments', 
    'platform_new_platform_title' => 'New link with one LMS',
    'platform_not_found' => 'No platforms have been added yet',
    'platform_deployment_id_label' => 'Deployment id',
    'platform_add_new_button' => 'ADD PLATFORM',
    'save_button' => 'SAVE',
    'platform_create_error' => 'The platform could not be added.',
    'platform_create_success' => 'The platform was created successfully.',
    'platform_confirm_delete' => '¿Are you sure you want to remove the platform: :name ?',
    'platform_create_subtitle' => 'LMS platform data',
    'platform_create_description' => 'In this section you can link your LTI with a new LMS. Except for the name which is to reference the LMS locally, the rest of the values are provided after adding a new lti tool in the LMS. The signing method is usually the default for Moodle and Canvas, only update the value if you are sure. You can maintain a linked LMS that does not have installations in any courses or at the platform level (Enabled by default for all courses). Each installation within the LMS will give a new deployment_id that you must register manually if you want to control the LTI installations, if not, you can enable the option to auto register those deployment_id.',
    'platform_instances_subtitle' => 'LMS platform instances',
    'platform_instances_description' => 'Once you link the tool with the LMS you can install it in different courses or for all the courses in your LMS. Each install is a different new deployment_id and can be controlled differently if you specify a target_link_uri (This value is defined by you and must be handled later in programming to do your stuff). The deployment_id is a code that is delivered by the LMS after installation.',
    'platform_add_instance_button' => 'ADD OTHER DEPLOYMENT ID',
    'auto_register_deployments_enable' => 'Enable',
    'auto_register_deployments_disable' => 'Disable',
    'deployment_add_title' => 'Add new deployment for: :platform_name',
    'deployment_id_label' => 'Deployment id',
    'creation_method_label' => 'Creation method',
    'created_at_label' => 'Creado el: :date',
    'deployment_confirm_delete' => '¿Are you sure you want to remove the deployment: :id ?',
    'deployment_created_successfully' => 'Deployment was added successfully',
    'deployment_deleted_successfully' => 'Deployment was deleted successfully',
    'deployment_creation_failed' => 'The deployment could not be added.'
];
