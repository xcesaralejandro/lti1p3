<?php

namespace xcesaralejandro\lti1p3\Classes;

use App\Models\Instance;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use xcesaralejandro\lti1p3\Facades\Lti;


class Nrps extends Service {
    const MEDIA_TYPE_MEMBERSHIPS_NRPS = 'application/vnd.ims.lti-nrps.v2.membershipcontainer+json';

    public function listAll(Instance $instance){
        $verify_https = config('lti1p3.VERIFY_HTTPS_CERTIFICATE');
        $client = new Client(['verify' => $verify_https]);
        $url = $instance->platform->lti_advantage_token_url;
        $payload = array(
            "iss" => $instance->platform->issuer_id,
            "sub" => $instance->platform->client_id,
            "aud" => $url,
            "iat" => time()-200,
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
        $nrps_endpoint = $this->getNrspEndpoint($instance); 
        if(empty($nrps_endpoint)){
            throw new \Exception("Nrps is not enabled.");
        }
        $response = $client->request('GET', $nrps_endpoint, ['headers' => $headers]);
        $content = json_decode($response->getBody()->getContents(), true);
        dd("NRPS RESPONSE: ", $content);
        $response = $content;
    }

    private function getNrspEndpoint(Instance $instance) : ?string {
        $message_content = Message::decodeJWTMessage($instance->platform, $instance->initial_message);
        $nrps_config = $message_content->getNrpsServiceConfig();
        return $nrps_config->context_memberships_url ?? null;
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



