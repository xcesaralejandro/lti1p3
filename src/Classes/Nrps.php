<?php

namespace xcesaralejandro\lti1p3\Classes;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use xcesaralejandro\lti1p3\Facades\Lti;


class Nrps extends Service {
    const LTI_SPEC_NRPS_CLAIM = 'https://purl.imsglobal.org/spec/lti-nrps/claim/namesroleservice';
    const MEDIA_TYPE_MEMBERSHIPS_NRPS = 'application/vnd.ims.lti-nrps.v2.membershipcontainer+json';

    public function isEnabled() : bool {
        return isset($this->instance->content->getRawJwt()?->{self::LTI_SPEC_NRPS_CLAIM});
    }

    public function listAll(){
        $verify_https = config('lti1p3.VERIFY_HTTPS_CERTIFICATE');
        $client = new Client(['verify' => $verify_https]);
        $url = "https://udec.test.instructure.com/login/oauth2/token";
        $payload = array(
            "iss" => "https://packagetester.cl",
            "sub" => $this->instance->platform->client_id,
            "aud" => $url,
            "iat" => time(),
            "exp" => time() + 6000,
            "jti" =>  (string) Uuid::uuid4()
        );
        $rsa_key = config('lti1p3.PRIVATE_KEY');
        $kid = config('lti1p3.KID');
        $jwt = JWT::encode($payload, $rsa_key, 'RS256', $kid);
        $scopes = ['https://purl.imsglobal.org/spec/lti-nrps/scope/contextmembership.readonly'];
        $params = [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_assertion_type' => 'urn:ietf:params:oauth:client-assertion-type:jwt-bearer',
                'client_assertion' => $jwt,
                'scope' => implode(' ', $scopes)
            ]
        ];
        $response = $client->request('POST', $url, $params);
        $content = json_decode($response->getBody()->getContents(), true);

        $token = $content["access_token"];
        $headers = ['Authorization' => "Bearer $token"];
        $response = $client->request('GET', $this->getUrl(), ['headers' => $headers]);
        $content = json_decode($response->getBody()->getContents(), true);

        dd($content);
        $response = $content;
    }

    private function getUrl() : ?string {
        return $this->getConfig()?->context_memberships_url;
    }

    private function getConfig() : ?object {
        $config = null;
        if($this->isEnabled()){
            $config = $this->instance->content->getRawJwt()?->{self::LTI_SPEC_NRPS_CLAIM};
        }
        return $config;
    }

}

// WORKING FOR CANVAS

// public function listAll(){
//     $verify_https = config('lti1p3.VERIFY_HTTPS_CERTIFICATE');
//     $client = new Client(['verify' => $verify_https]);
//     $url = "https://udec.test.instructure.com/login/oauth2/token";
//     $payload = array(
//         "iss" => "https://packagetester.cl",
//         "sub" => $this->instance->platform->client_id,
//         "aud" => $url,
//         "iat" => time(),
//         "exp" => time() + 600,
//         "jti" =>  (string) Uuid::uuid4()
//     );
//     $rsa_key = config('lti1p3.PRIVATE_KEY');
//     $kid = config('lti1p3.KID');
//     $jwt = JWT::encode($payload, $rsa_key, 'RS256', $kid);
//     $scopes = ['https://purl.imsglobal.org/spec/lti-nrps/scope/contextmembership.readonly'];
//     $params = [
//         'form_params' => [
//             'grant_type' => 'client_credentials',
//             'client_assertion_type' => 'urn:ietf:params:oauth:client-assertion-type:jwt-bearer',
//             'client_assertion' => $jwt,
//             'scope' => implode(' ', $scopes)
//         ]
//     ];
//     $response = $client->request('POST', $url, $params);
//     $content = json_decode($response->getBody()->getContents(), true);
//     dd($content);
//     $response = $content;
// }



