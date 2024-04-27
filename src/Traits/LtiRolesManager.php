<?php
    namespace xcesaralejandro\lti1p3\Traits;

use App\Models\LtiContext;
use App\Models\LtiUserRole;

    trait LtiRolesManager {
        public static $SYSTEM_ROLES = 'http://purl.imsglobal.org/vocab/lis/v2/system/person#';
        public static $INSTITUTIONAL_ROLES = 'http://purl.imsglobal.org/vocab/lis/v2/institution/person#';
        public static $CONTEX_ROLES = 'http://purl.imsglobal.org/vocab/lis/v2/membership#';
        public static $PERSON_ROLES = 'http://purl.imsglobal.org/vocab/lti/system/person#';
        private array $context_roles = [];

        public function isAdmin(LtiContext $context, ?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_ADMIN_ROLES_SPEC');
            return $this->hasSomeRolesOf($context, $roles, $role_context);
        }

        public function isContentDeveloper(LtiContext $context, ?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_CONTENT_DEVELOPER_ROLES_SPEC');
            return $this->hasSomeRolesOf($context, $roles, $role_context);
        }

        public function isInstructor(LtiContext $context, ?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_INSTRUCTOR_ROLES_SPEC');
            return $this->hasSomeRolesOf($context, $roles, $role_context);
        }

        public function isLearner(LtiContext $context, ?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_LEARNER_ROLES_SPEC');
            return $this->hasSomeRolesOf($context, $roles, $role_context);
        }

        public function isManager(LtiContext $context, ?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_MANAGER_ROLES_SPEC');
            return $this->hasSomeRolesOf($context, $roles, $role_context);
        }

        public function isMentor(LtiContext $context, ?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_MENTOR_ROLES_SPEC');
            return $this->hasSomeRolesOf($context, $roles, $role_context);
        }

        public function isOfficer(LtiContext $context, ?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_OFFICER_ROLES_SPEC');
            return $this->hasSomeRolesOf($context, $roles, $role_context);
        }

        public function isMember(LtiContext $context, ?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_MEMBER_ROLE_SPEC');
            return $this->hasSomeRolesOf($context, $roles, $role_context);
        }

        public function isTestUser(LtiContext $context, ?string $role_context = null) : bool {
            $roles = config('lti1p3.LTI_TEST_USER_ROLE_SPEC');
            return $this->hasSomeRolesOf($context, $roles, $role_context);
        }

        public function hasSomeRolesOf(LtiContext $context, array $role_list, ?string $role_context=null) : bool {
            $hasRole = false;
            foreach ($role_list as $role_name){
                if($this->hasRole($context, $role_name, $role_context)){
                    return true;
                }
            }
            return $hasRole;
        }

        public function hasRole(LtiContext $context, string $role_name , ?string $role_context = null) : bool {
            $roles = [];
            if($role_context == static::$SYSTEM_ROLES){
                $roles = $this->getSystemRoles($context);
            }else if ($role_context == static::$INSTITUTIONAL_ROLES) {
                $roles = $this->getInstitutionRoles($context);
            }else if ($role_context == static::$CONTEX_ROLES) {
                $roles = $this->getContextRoles($context);
            }else{
                $roles = $this->getAllRoles($context);
            }
            $has_role = in_array($role_name, $roles);
            return $has_role;
        }

        public function getAllRoles(LtiContext $context){
            $system_roles = $this->getSystemRoles($context);
            $institution_roles = $this->getInstitutionRoles($context);
            $context_roles = $this->getContextRoles($context);
            $person_roles = $this->getPersonRoles($context);
            $roles = array_merge($system_roles, $institution_roles, $context_roles, $person_roles);
            $roles = array_unique($roles, SORT_REGULAR);
            return $roles;
        }

        public function getSystemRoles(LtiContext $context) : array {
            $roles = $this->getLtiRolesFromContext($context);
            $roles = $this->toFriendlyRoles($roles, static::$SYSTEM_ROLES);
            return $roles;
        }

        public function getInstitutionRoles(LtiContext $context) : array {
            $roles = $this->getLtiRolesFromContext($context);
            $roles = $this->toFriendlyRoles($roles, static::$INSTITUTIONAL_ROLES);
            return $roles;
        }

        public function getContextRoles(LtiContext $context) : array {
            $roles = $this->getLtiRolesFromContext($context);
            $roles = $this->toFriendlyRoles($roles, static::$CONTEX_ROLES);
            return $roles;
        }

        public function getPersonRoles(LtiContext $context) : array {
            $roles = $this->getLtiRolesFromContext($context);
            $roles = $this->toFriendlyRoles($roles, static::$PERSON_ROLES);
            return $roles;
        }

        private function getLtiRolesFromContext(LtiContext $context) : array {
            $request_key = "{$context->id}{$this->id}";
            $has_previous_request = isset($this->context_roles[$request_key]);
            if($has_previous_request){
                return $this->context_roles[$request_key];
            }else{
                $roles = LtiUserRole::select('name')->where('lti1p3_user_id', $this->id)
                ->where('lti1p3_context_id', $context->id)->pluck('name')->toArray();
                $this->context_roles[$request_key] = $roles;
            }
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
