<?php
    namespace xcesaralejandro\lti1p3\Traits;

    trait LtiRolesManager {
        public static $SYSTEM_ROLES = 'http://purl.imsglobal.org/vocab/lis/v2/system/person#';
        public static $INSTITUTIONAL_ROLES = 'http://purl.imsglobal.org/vocab/lis/v2/institution/person#';
        public static $CONTEX_ROLES = 'http://purl.imsglobal.org/vocab/lis/v2/membership#';
        public static $PERSON_ROLES = 'http://purl.imsglobal.org/vocab/lti/system/person#';

        public function isAdmin(?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_ADMIN_ROLES_SPEC');
            return $this->hasSomeRolesOf($roles, $role_context);
        }

        public function isContentDeveloper(?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_CONTENT_DEVELOPER_ROLES_SPEC');
            return $this->hasSomeRolesOf($roles, $role_context);
        }

        public function isInstructor(?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_INSTRUCTOR_ROLES_SPEC');
            return $this->hasSomeRolesOf($roles, $role_context);
        }

        public function isLearner(?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_LEARNER_ROLES_SPEC');
            return $this->hasSomeRolesOf($roles, $role_context);
        }

        public function isManager(?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_MANAGER_ROLES_SPEC');
            return $this->hasSomeRolesOf($roles, $role_context);
        }

        public function isMentor(?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_MENTOR_ROLES_SPEC');
            return $this->hasSomeRolesOf($roles, $role_context);
        }

        public function isOfficer(?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_OFFICER_ROLES_SPEC');
            return $this->hasSomeRolesOf($roles, $role_context);
        }

        public function isMember(?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_MEMBER_ROLE_SPEC');
            return $this->hasSomeRolesOf($roles, $role_context);
        }

        public function isTestUser(?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_TEST_USER_ROLE_SPEC');
            return $this->hasSomeRolesOf($roles, $role_context);
        }

        public function hasSomeRolesOf(array $role_list, ?string $role_context=null) : bool {
            $hasRole = false;
            foreach ($role_list as $role_name){
                if($this->hasRole($role_name, $role_context)){
                    return true;
                }
            }
            return $hasRole;
        }

        public function hasRole(string $role_name , ?string $role_context = null) : bool {
            $roles = [];
            if($role_context == static::$SYSTEM_ROLES){
                $roles = $this->getSystemRoles();
            }else if ($role_context == static::$INSTITUTIONAL_ROLES) {
                $roles = $this->getInstitutionRoles();
            }else if ($role_context == static::$CONTEX_ROLES) {
                $roles = $this->getContextRoles();
            }else{
                $roles = $this->getAllRoles();
            }
            $has_role = in_array($role_name, $roles);
            return $has_role;
        }

        public function getAllRoles(){
            $system = $this->getSystemRoles();
            $institution = $this->getInstitutionRoles();
            $context = $this->getContextRoles();
            $person = $this->getPersonRoles();
            $roles = array_merge($system, $institution, $context, $person);
            $roles = array_unique($roles, SORT_REGULAR);
            return $roles;
        }

        public function getSystemRoles() : array {
            $roles = explode(' ', $this->roles);
            $roles = $this->toFriendlyRoles($roles, static::$SYSTEM_ROLES);
            return $roles;
        }

        public function getInstitutionRoles() : array {
            $roles = explode(' ', $this->roles);
            $roles = $this->toFriendlyRoles($roles, static::$INSTITUTIONAL_ROLES);
            return $roles;
        }

        public function getContextRoles() : array {
            $roles = explode(' ', $this->roles);
            $roles = $this->toFriendlyRoles($roles, static::$CONTEX_ROLES);
            return $roles;
        }

        public function getPersonRoles() : array {
            $roles = explode(' ', $this->roles);
            $roles = $this->toFriendlyRoles($roles, static::$PERSON_ROLES);
            return $roles;
        }

        private function toFriendlyRoles(array $roles, string $scope) : array {
            $friendlyRoles = [];
            $start = strlen($scope);
            foreach($roles as $role){
                $isConsultedScope = (strpos($role, $scope) !== false);
                if($isConsultedScope){
                    $end = strlen($role);
                    $role = substr($role, $start, $end);
                    array_push($friendlyRoles, $role);
                }
            }
            return $friendlyRoles;
        }
    }
