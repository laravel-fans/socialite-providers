<?php

namespace LaravelSocialiteProviders\Coding;

use Illuminate\Support\Arr;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'CODING';

    /**
     * {@inheritdoc}
     */
    protected $scopes = ['user'];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        // HACK: CODING 每个注册团队都是单独的二级域名，需要传递进来，目前发现有 with 和 guzzle 两种方法可以实现，这里选择 guzzle。
        return $this->buildAuthUrlFromBase($this->guzzle['base_uri'] . 'oauth_authorize.html', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return '/api/oauth/access_token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('/api/account/current_user', [
            'query' => [
                'access_token' => $token,
            ],
        ]);

        return json_decode($response->getBody(), true)['data'];
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'       => $user['id'],
            'nickname' => null,
            'name'     => $user['name'],
            'email'    => isset($user['email']) ? $user['email'] : null,
            'avatar'   => $user['avatar'],
        ]);
    }
}
