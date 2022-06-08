<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestCommand extends Command
{
    private const AUTHENTICATION_URI = '/oxauth/restv1/token';

    private const INSPECT_TOKEN_URI = '/oxauth/restv1/introspection';

    private const CREATE_USER_URI = '/identity/restv1/scim/v2/Users';

    private const UPDATE_USER_URI = '';

    private $gluuClientId;

    private $gluuClientSecret;

    private $gluuBaseURL;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diag:test-gluu-process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */


    public function authenticate($username, $password, $grantType)
    {
        $this->info("Authenticate User");
        $response = Http::withoutVerifying()
            ->acceptJson()
            ->asForm()
            ->withBasicAuth($this->gluuClientId, $this->gluuClientSecret)
            ->post(
                $this->gluuBaseURL.self::AUTHENTICATION_URI,
                [
                    "grant_type" => $grantType,
                    "username" => $username,
                    "password" => $password
                ]
            );
        if ($response->status() == 200) {
            $accessToken = $response->object()->access_token;
            $this->info($accessToken);
            return $accessToken;
        }
        $this->error("Invalid user info");
        return false;
    }

    public function inspectToken($accessToken)
    {
        $this->info("Inspect token : ".$accessToken);
        $response = Http::withoutVerifying()
            ->acceptJson()
            ->withBasicAuth($this->gluuClientId, $this->gluuClientSecret)
            ->get($this->gluuBaseURL.self::INSPECT_TOKEN_URI, ['token' => $accessToken]);
        if ($response->status() == 200) {
            $this->info("Valid Token");
            $this->info($response->body());
            return $response->object();
        }
        $this->error("Invalid Token");
        return false;
    }

    public function register($username, $password)
    {
        $this->info("Register User");
        $userSample = [
            "schemas"=> [
                "string"
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
                    "value" =>  "gossow@nsfw.com",
                    "display" =>  "string",
                    "type" =>  "work",
                    "primary" => true
                ]
            ],
        ];
        dd(json_encode($userSample));
        $response = Http::withoutVerifying()
            ->asJson()
            ->withBasicAuth($this->gluuClientId, $this->gluuClientSecret)
            ->post(
                $this->gluuBaseURL.self::CREATE_USER_URI,
                $userSample
            );

        dd($response);
        $this->error("Error, Cant create user");
        return false;
    }

    public function handle()
    {
        $this->gluuClientId = env('GLUU_CLIENT_ID');
        $this->gluuClientSecret = env('GLUU_CLIENT_SECRECT');
        $this->gluuBaseURL = env('GLUU_HOST');
        $username = "toanat1";
        $password = "123456";
        $grantType = "password";
        $this->register($username, $password);

        $this->warn("Authenticate user ".$username);
        $accessToken = $this->authenticate($username, $password, $grantType);
        if (!$accessToken) {
            return 1;
        }
        $this->warn("Send a valid token");
        $userObject = $this->inspectToken($accessToken);
        if (!$userObject) {
            return 1;
        }
        $invalidAccessToken = "Invalid token 123";
        $this->warn("Try to send invalid token");
        $this->inspectToken($invalidAccessToken);
        return 0;
    }
}
