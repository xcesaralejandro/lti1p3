<?php
namespace xcesaralejandro\lti1p3\Classes;

use Illuminate\Contracts\View\View;
use xcesaralejandro\lti1p3\DataStructure\ResourceLinkInstance;
use xcesaralejandro\lti1p3\DataStructure\DeepLinkingInstance;
use xcesaralejandro\lti1p3\Http\Requests\LaunchRequest;
use xcesaralejandro\lti1p3\Models\LtiNonce;
use App\Models\LtiContext;
use App\Models\LtiPlatform;
use App\Models\LtiResourceLink;
use App\Models\LtiUser;
use App\Models\LtiUserRole;
use App\Models\LtiDeployment;
use App\Models\LtiInstance;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class Launch {

        public function isLoginHint(LaunchRequest $request) : bool {
            return isset($request->login_hint);
        }

        public function isSuccessfully(LaunchRequest $request) : bool {
            return  isset($request->id_token);
        }

        public function attemptLogin (LaunchRequest $request) : View {
            $platform = LtiPlatform::where(['issuer_id' => $request->iss,
                'client_id' => $request->client_id])->firstOrFail();
            $login_request = ['url' => $platform->authentication_url,
                'params' => $this->loginParams($platform, $request)];
            return View('lti1p3::helpers.autoSubmitForm', $login_request);
        }

        private function loginParams(LtiPlatform $platform, LaunchRequest $request) : array {
            $nonce = LtiNonce::create(['lti1p3_platform_id' => $platform->id]);
            $params = array(
                'client_id' => $platform->client_id,
                'login_hint' => $request->login_hint,
                'lti_message_hint' => $request->lti_message_hint,
                'nonce' => $nonce->id,
                'prompt' => 'none',
                'redirect_uri' => route('lti1p3.connect'),
                'response_mode' => 'form_post',
                'response_type' => 'id_token',
                'scope' => 'openid',
                'state' => $nonce->id
            );
           return $params;
        }

        public function syncResourceLinkRequest(Message $message) : ResourceLinkInstance {
            $platform = $message->getPlatform();
            $content = $message->getContent();
            $platform = Launch::syncPlatform($content, $platform);
            $deployment = Launch::syncDeployment($content, $platform);
            $user = Launch::syncUser($content, $platform->id);
            $context = Launch::syncContext($content, $deployment->id);
            $resourceLink = Launch::SyncResourceLink($content, $context);
            Launch::SyncUserRoles($content, $user->id, $context->id);
            $instance = new ResourceLinkInstance();
            $instance->platform = $platform;
            $instance->deployment = $deployment;
            $instance->context = $context;
            $instance->resourceLink = $resourceLink;
            $instance->user = $user;
            $instance->message = $message;
            return $instance;
        }

        public function syncDeepLinkingRequest(Message $message) : DeepLinkingInstance {
            $platform = $message->getPlatform();
            $content = $message->getContent();
            $platform = Launch::syncPlatform($content, $platform);
            $deployment = Launch::syncDeployment($content, $platform);
            $user = Launch::syncUser($content, $platform->id);
            $context = Launch::syncContext($content, $deployment->id);
            Launch::SyncUserRoles($content, $user->id, $context->id);
            $instance = new DeepLinkingInstance();
            $instance->platform = $platform;
            $instance->deployment = $deployment;
            $instance->context = $context;
            $instance->user = $user;
            $instance->message = $message;
            return $instance;
        }

        public function SyncUserRoles(Content $content, int $user_id, int $lti1p3_context_id) : void {
            $current_roles = $content->getUserRoles();
            $existing_roles = LtiUserRole::where('lti1p3_user_id', $user_id)->where('lti1p3_context_id', $lti1p3_context_id)
            ->pluck('name')->toArray();
            $for_add = array_diff($current_roles, $existing_roles);
            $for_remove = array_diff($existing_roles, $current_roles);
            LtiUserRole::where('lti1p3_user_id', $user_id)->where('lti1p3_context_id', $lti1p3_context_id)
            ->whereIn('name', $for_remove)->delete();
            foreach ($for_add as $role_name){
                LtiUserRole::create(['lti1p3_context_id' => $lti1p3_context_id, 'lti1p3_user_id' => $user_id,
                'name' => $role_name]);
            }
        }

        public function syncPlatform(Content $content, LtiPlatform $platform) : LtiPlatform {
            $platform->guid = $content->getPlatform()->guid ?? null;
            $platform->name = $content->getPlatform()->name ?? null;
            $platform->version = $content->getPlatform()->version ?? null;
            $platform->product_family_code = $content->getPlatform()->product_family_code ?? null;
            $platform->update();
            return $platform;
        }

        public function syncDeployment(Content $content, LtiPlatform $platform) : mixed {
            $deployment = LtiDeployment::where('lti_id', $content->getDeploymentId())->where('lti1p3_platform_id', $platform->id)->first();
            if(empty($deployment) && $platform->deployment_id_autoregister){
                $deployment = LtiDeployment::create(['lti1p3_platform_id' => $platform->id,
                    'lti_id' => $content->getDeploymentId(), 'creation_method' => 'AUTOREGISTER']);
            }
            return $deployment;
        }

        public function syncUser(Content $content, int $platform_id) : LtiUser {
            $fields = [
                'name' => $content->getUserName(),
                'given_name' => $content->getUserGivenName(),
                'family_name' => $content->getUserFamilyName(),
                'email' => $content->getUserEmail(),
                'picture' => $content->getUserPicture(),
                'roles' => implode(";", $content->getUserRoles()),
                'person_sourceid' => $content->getLis()->person_sourcedid ?? null,
            ];
            $conditions = ['lti_id' => $content->getUserId(), 'lti1p3_platform_id' => $platform_id];
            $user = LtiUser::updateOrCreate($conditions, $fields);
            return $user;
        }

        public function syncContext(Content $content, int $deployment_id) : LtiContext {
            $fields = [
                'label' => $content->getContext()->label ?? null,
                'title' => $content->getContext()->title  ?? null,
                'type' => implode(";", $content->getContext()->type  ?? null)
            ];
            $conditions = ['lti_id' => $content->getContext()->id  ?? null,'lti1p3_deployment_id' => $deployment_id];
            $context = LtiContext::updateOrCreate($conditions, $fields);
            return $context;
        }

        public function SyncResourceLink(Content $content, LtiContext $context) : LtiResourceLink {
            $fields = [
                'description' => $content->getResourceLink()->description ?? null,
                'title' => $content->getResourceLink()->title ?? null
            ];
            $lti_id = $content->getResourceLink()->id  ?? null;
            $conditions = ['lti_id' => $lti_id, 'lti1p3_context_id' => $context->id];
            $resourceLink = LtiResourceLink::updateOrCreate($conditions, $fields);
            return $resourceLink;
        }

        public function storeInstance(ResourceLinkInstance|DeepLinkingInstance $instance) : string {
            do{
                $uuid = (string) Uuid::uuid4();
                $fields =  [
                    'id' => $uuid,
                    'lti1p3_platform_id' => $instance->platform->id,
                    'lti1p3_deployment_id' => $instance->deployment->id,
                    'lti1p3_context_id' => $instance->context->id,
                    'lti1p3_resource_link_id' => $instance->resourceLink->id ?? null,
                    'lti1p3_user_id' => $instance->user->id,
                    'initial_message' => $instance->message->getRawJwtContent(),
                    'created_at' => Carbon::now()
                ];
            }while(!LtiInstance::create($fields));
            return $uuid;
        }
    }
