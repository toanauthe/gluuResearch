<?php
namespace App\Services\Gluu;

use App\KafkaHandler\RegisterHandler;
use Illuminate\Support\Facades\Http;

class GluuService
{
    private const AUTHENTICATION_URI = '/oxauth/restv1/token';

    private const INSPECT_TOKEN_URI = '/oxauth/restv1/introspection';

    private const CREATE_USER_URI = '/identity/restv1/scim/v2/Users';

    private const UPDATE_USER_URI = '';

    public function __construct(private ?string $gluuClientId = null,private ?string $gluuClientSecret = null,private ?string $gluuBaseURL = null)
    {
        $this->gluuClientId = env('GLUU_CLIENT_ID');
        $this->gluuClientSecret = env('GLUU_CLIENT_SECRECT');
        $this->gluuBaseURL = env('GLUU_HOST');
    }

    public function setGluuClientId($gluuClientId): static
    {
        $this->gluuClientId = $gluuClientId;
        return $this;
    }

    public function setGluuClientSecret($gluuClientSecret): static
    {
        $this->gluuClientSecret = $gluuClientSecret;
        return $this;
    }

    public function setGluuBaseURL($gluuBaseURL): static
    {
        $this->gluuBaseURL = $gluuBaseURL;
        return $this;
    }

    public function register($username, $email, $password): bool
    {
        $registerToken = $this->authenticate(null, null, 'client_credentials', "https://gluu.org/scim/users.write");
        $userSample = [
            "schemas"=> [
                "urn:ietf:params:scim:schemas:core:2.0:User"
            ],
            "userName" => $username,
            "displayName" => $username,
            "name"=> [
                "familyName"=> "string",
                "givenName"=> "string",
                "middleName"=> "string",
                "honorificPrefix"=> "string",
                "honorificSuffix"=> "string",
                "formatted"=> "string"
            ],
            "password" => $password,
            "active"=> true,
            "emails" => [
                [
                    "value" =>  $email,
                    "display" =>  "string",
                    "type" =>  "work",
                    "primary" => true
                ]
            ],
        ];
        $response = Http::withoutVerifying()
            ->asJson()
            ->withToken($registerToken)
            ->post(
                $this->gluuBaseURL.self::CREATE_USER_URI,
                $userSample
            );

        if ($response->status()==201) {
            return true;
        }
        return false;
    }

    public function authenticate($username, $password, $grantType, $scope = null): bool
    {
        $response = Http::withoutVerifying()
            ->acceptJson()
            ->asForm()
            ->withBasicAuth($this->gluuClientId, $this->gluuClientSecret)
            ->post(
                $this->gluuBaseURL.self::AUTHENTICATION_URI,
                [
                    "grant_type" => $grantType,
                    "username" => $username,
                    "password" => $password,
                    "scope"   => $scope
                ]
            );
        if ($response->status() == 200) {
            return $response->object()->access_token;
        }
        return false;
    }

    public function inspectToken($accessToken): object|bool|array
    {
        $response = Http::withoutVerifying()
            ->acceptJson()
            ->withBasicAuth($this->gluuClientId, $this->gluuClientSecret)
            ->get($this->gluuBaseURL.self::INSPECT_TOKEN_URI, ['token' => $accessToken]);
        if ($response->status() == 200) {
            return $response->object();
        }
        return false;
    }
}
