<?php
namespace xcesaralejandro\lti1p3\Classes;

use Illuminate\Contracts\View\View;
use xcesaralejandro\lti1p3\Http\Requests\LaunchRequest;
use App\Models\Context;
use xcesaralejandro\lti1p3\Models\Nonce;
use App\Models\Platform;
use App\Models\ResourceLink;
use App\Models\User;
use App\Models\UserRole;
use xcesaralejandro\lti1p3\DataStructure\Instance;
use xcesaralejandro\lti1p3\Models\Deployment;

class Launch {

        public function isLoginHint(LaunchRequest $request) : bool {
            return isset($request->login_hint);
        }
    
        public function isSuccessfulLoginAttempt(LaunchRequest $request) : bool {
            return  isset($request->id_token);
        }

        public function isFinalRequest(Content $content) : bool {
            return !$this->isUnsignedRequest($content);
        }

        public function attemptLogin (LaunchRequest $request) : View {
            $platform = Platform::where(['issuer_id' => $request->iss, 
                'client_id' => $request->client_id])->firstOrFail();
            $login_request = ['url' => $platform->authentication_url,
                'params' => $this->loginParams($platform, $request)];
            return View('lti1p3::helpers.autoSubmitForm', $login_request);
        }

        private function loginParams(Platform $platform, LaunchRequest $request) : array {
            $nonce = Nonce::create(['platform_id' => $platform->id]);
            $params = array(
                'client_id' => $platform->client_id,
                'login_hint' => $request->login_hint,
                'lti_message_hint' => $request->lti_message_hint,
                'nonce' => $nonce->value,
                'prompt' => 'none',
                'redirect_uri' => route('lti1p3.connect'),
                'response_mode' => 'form_post',
                'response_type' => 'id_token',
                'scope' => 'openid',
                'state' => $nonce->value
            );
           return $params;
        }

        public function syncAll(Content $content, Platform $platform) : Instance {
            $platform = Launch::syncPlatform($content, $platform);
            $deployment = Launch::syncDeployment($content, $platform);
            $user = Launch::syncUser($content, $platform->id);
            $context = Launch::syncContext($content, $deployment->id);
            $resourceLink = Launch::SyncResourceLink($content, $context);
            Launch::SyncUserRoles($content, $user->id, $context->id);
            $instance = new Instance();
            $instance->platform = $platform;
            $instance->deployment = $deployment;
            $instance->context = $context;
            $instance->resourceLink = $resourceLink;
            $instance->user = $user;
            return $instance;
        }

        public function SyncUserRoles(Content $content, int $user_id, int $lti_context_id) : void {
            $current_roles = $content->getClaims()?->roles ?? [];
            $existing_roles = UserRole::where('user_id', $user_id)->where('lti_context_id', $lti_context_id)
            ->where('creation_context', 'LTI')->pluck('name')->toArray();
            $for_add = array_diff($current_roles, $existing_roles);
            $for_remove = array_diff($existing_roles, $current_roles);
            UserRole::where('user_id', $user_id)->where('lti_context_id', $lti_context_id)
            ->where('creation_context', 'LTI')->whereIn('name', $for_remove)->delete();
            foreach ($for_add as $role_name){
                UserRole::create(['lti_context_id' => $lti_context_id, 'user_id' => $user_id,
                'name' => $role_name, 'creation_context' => 'LTI']);
            }
        }

        public function syncPlatform(Content $content, Platform $platform) : Platform {
            $platform->guid = $content->getPlatform()?->guid;
            $platform->name = $content->getPlatform()?->name;
            $platform->version = $content->getPlatform()?->version;
            $platform->product_family_code = $content->getPlatform()?->product_family_code;
            $platform->validation_context = $content->optionalPlatformAttribute('validation_context');
            $platform->update();
            return $platform;
        }

        public function syncDeployment(Content $content, Platform $platform) : mixed {
            $deployment = Deployment::where('lti_id', $content->getDeploymentId())->where('platform_id', $platform->id)->first();
            if(empty($deployment) && $platform->deployment_id_autoregister){
                $deployment = Deployment::create(['platform_id' => $platform->id,
                    'lti_id' => $content->getDeploymentId(), 'creation_method' => 'AUTOREGISTER']);
            }
            return $deployment;
        }
        
        public function syncUser(Content $content, int $platform_id) : User {
            $fields = [
                'name' => $content->getUserName(),
                'given_name' => $content->getUserGivenName(),
                'family_name' => $content->getUserFamilyName(),
                'email' => $content->getUserEmail(),
                'picture' => $content->getUserPicture(),
                'roles' => implode(" ", $content->getClaims()->roles),
                'person_sourceid' => $content->getClaims()->lis->person_sourcedid,
            ];
            $conditions = ['lti_id' => $content->getUserId(), 'platform_id' => $platform_id];
            $user = User::updateOrCreate($conditions, $fields);
            return $user;
        }

        public function syncContext(Content $content, int $deployment_id) : Context {
            $fields = [
                'label' => $content->getContext()?->label,
                'title' => $content->getContext()?->title,
                'type' => implode(" ", $content->getContext()?->type)
            ];
            $conditions = ['lti_id' => $content->getClaims()->context->id,'deployment_id' => $deployment_id];
            $context = Context::updateOrCreate($conditions, $fields);
            return $context;
        }
    
        public function SyncResourceLink(Content $content, Context $context) : ResourceLink {
            $fields = [
                'description' => $content->optionalResourceLinkAttribute('description'),
                'title' => $content->getResourceLink()?->title,
                'validation_context' => $content->optionalResourceLinkAttribute('validation_context')
            ];
            $lti_id = $content->getResourceLink()?->id;
            $conditions = ['lti_id' => $lti_id, 'context_id' => $context->id];
            $resourceLink = ResourceLink::updateOrCreate($conditions, $fields);
            return $resourceLink;
        }
    }