<?php 
// You can generate a private key here (2048 bit recommended):
// https://travistidwell.com/jsencrypt/demo/

return [

    'ENABLE_AUTH' => true,
    
    'VERIFY_HTTPS_CERTIFICATE' => false,

    'SIGNATURE_METHOD' => 'RS256',
    
    'KID' => 'default_kid', 
    
    'PRIVATE_KEY' => <<< EOD
    -----BEGIN RSA PRIVATE KEY-----
    Insert private key here
    -----END RSA PRIVATE KEY-----
    EOD,
    
    'LTI_ADMIN_ROLES_SPEC' => [
        'Administrator', 
        'Developer',
        'ExternalDeveloper',
        'ExternalSupport', 
        'ExternalSystemAdministrator', 
        'Support', 
        'SystemAdministrator'
    ],

    'LTI_CONTENT_DEVELOPER_ROLES_SPEC' => [
        'ContentDeveloper', 
        'ContentExpert',
        'ExternalContentExpert', 
        'Librarian'
    ],

    'LTI_INSTRUCTOR_ROLES_SPEC' => [
        'ExternalInstructor',
        'Grader',
        'GuestInstructor',
        'Lecturer',
        'PrimaryInstructor',
        'SecondaryInstructor',
        'TeachingAssistant',
        'TeachingAssistantGroup',
        'TeachingAssistantOffering', 
        'TeachingAssistantSection',
        'TeachingAssistantSectionAssociation', 
        'TeachingAssistantTemplate', 
        'Instructor'
    ],

    'LTI_LEARNER_ROLES_SPEC' => [
        'GuestLearner',
        'ExternalLearner',
        'Instructor',
        'Learner',
        'NonCreditLearner',
        'Student'
    ],

    'LTI_MANAGER_ROLES_SPEC' => [
        'AreaManager', 
        'CourseCoordinator', 
        'ExternalObserver',
        'Manager', 
        'Observer'
    ],

    'LTI_MENTOR_ROLES_SPEC' => [
        'Advisor',
        'Auditor',
        'ExternalAdvisor',
        'ExternalAuditor',
        'ExternalLearningFacilitator',
        'ExternalMentor',
        'ExternalReviewer',
        'ExternalTutor',
        'LearningFacilitator',
        'Mentor',
        'Reviewer',
        'Tutor'
    ],

    'LTI_OFFICER_ROLES_SPEC' => [
        'Chair',
        'Communications',
        'Secretary',
        'Treasurer',
        'Vice-Chair'
    ],

    'LTI_TEST_USER_ROLE_SPEC' => [
        'TestUser'
    ],

    'LTI_MEMBER_ROLE_SPEC' => [
        'Member'
    ]

];