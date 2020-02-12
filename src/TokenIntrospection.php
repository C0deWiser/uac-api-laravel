<?php


namespace Codewiser\UAC\Laravel;


use Closure;
use Codewiser\UAC\Laravel\Exceptions\UacApiException;
use League\OAuth2\Client\Token\AccessToken;

class TokenIntrospection
{
    /** @var \Illuminate\Http\Request $request */
    protected $request;

    /** @var UacClient */
    protected $uac;

    /**
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     */
    public function handle($request, Closure $next)
    {
        $this->request = $request;
        $this->uac = UacClient::Client();

        $this->validateRequest();

        $this->tokenIntrospection();

        return $next($this->request);
    }

    protected function validateRequest()
    {
        $access_token = $this->request->input('access_token');

        if (!$access_token) {
            $access_token = trim(str_replace('Bearer', '', $this->request->header('Authorization')));
        }

        if (!$access_token) {
            $this->throwUnauthorizedException();
        }
    }

    protected function tokenIntrospection()
    {
        $tokenInfo = $this->uac->tokenIntrospection(new AccessToken($this->request->only('access_token')));

        if (!$tokenInfo->getActive()) {
            $this->throwUnauthorizedException();
        }

        $this->request->request->add([
            'token_info' => $tokenInfo->toArray()
        ]);
    }

    protected function throwUnauthorizedException($message = 'invalid_token')
    {
        throw new UacApiException($message, 401);
    }
}