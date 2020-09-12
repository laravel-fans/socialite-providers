<?php

namespace LaravelFans\SocialiteProviders\Coding;

use SocialiteProviders\Manager\SocialiteWasCalled;

class CodingExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('coding', __NAMESPACE__.'\Provider');
    }
}
