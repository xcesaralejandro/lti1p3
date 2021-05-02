<?php
namespace xcesaralejandro\lti1p3\Classes;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use xcesaralejandro\lti1p3\Http\Requests\LaunchRequest;
use App\Models\Context;
use xcesaralejandro\lti1p3\Models\Nonce;
use App\Models\Platform;
use App\Models\ResourceLink;
use App\Models\User;

class Launch {

        public function isLoginHint(LaunchRequest $request) : bool {
            Log::debug("[Launch] [isLoginHint] Check login hint",
                $request->only(['iss', 'client_id']));
            return isset($request->login_hint);
        }
    
        public function isValidLogin(LaunchRequest $request) : bool {
            Log::debug("[Launch] [isValidLogin] Cheking login",
                $request->only(['id_token', 'state']));
            return isset($request->id_token);
        }

        public function attemptLogin (LaunchRequest $request) : View {
            $platform = Platform::where(['issuer_id' => $request->iss, 
                'client_id' => $request->client_id])->firstOrFail();
            $login_request = ['url' => $platform->authentication_url,
                'params' => $this->loginParams($platform, $request)];
            Log::debug("[Launch] [attemptLogin] Attempt login for platform id: {$platform->id}", 
                $login_request);
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

        public function SyncPlatform(Content $content, Platform $platform) : Platform {
            Log::debug('[Launch] [updatePlatform] Starting updating Platform');
            $platform->guid = $content->getPlatform()?->guid;
            $platform->name = $content->getPlatform()?->name;
            $platform->version = $content->getPlatform()?->version;
            $platform->product_family_code = $content->getPlatform()?->product_family_code;
            $platform->validation_context = $content->optionalPlatformAttribute('validation_context');
            $platform->target_link_uri = $content->optionalPlatformAttribute('target_link_uri');
            $platform->update();
            Log::debug('[Launch] [updatePlatform] Platform has been updated successfully');
            return $platform;
        }

        public function SyncUser(Content $content, int $platform_id) : User {
            Log::debug('[Launch] [updateOrCreateUser] Starting updating or creating User');
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
            Log::debug('[Launch] [updateOrCreateUser] User has been updated or created successfully');
            return $user;
        }

        public function SyncContext(Content $content, int $platform_id) : Context {
            Log::debug('[Launch] [updateOrCreateContext] Starting updating or creating Context');
            $fields = [
                'label' => $content->getContext()?->label,
                'title' => $content->getContext()?->title,
                'type' => implode(" ", $content->getContext()?->type)
            ];
            $conditions = ['lti_id' => $content->getClaims()->context->id,'platform_id' => $platform_id];
            $context = Context::updateOrCreate($conditions, $fields);
            Log::debug('[Launch] [updateOrCreateContext] Context has been updated or created successfully');
            return $context;
        }
    
        public function SyncResourceLink(Content $content, Context $context) : ResourceLink {
            Log::debug('[Launc] [SyncResourceLink] Starting updating or creating ResourceLink');
            $fields = [
                'description' => $content->optionalResourceLinkAttribute('description'),
                'title' => $content->getResourceLink()?->title,
                'validation_context' => $content->optionalResourceLinkAttribute('validation_context')
            ];
            $lti_id = $content->getResourceLink()?->id;
            $conditions = ['lti_id' => $lti_id, 'context_id' => $context->id];
            $resourceLink = ResourceLink::updateOrCreate($conditions, $fields);
            Log::debug('[Launch] [SyncResourceLink] ResourceLink has been updated or created successfully');
            return $resourceLink;
        }
    }