<?php

namespace Caxy\Bundle\AppEngineBundle\Controller;

use google\appengine\api\users\UserService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;

/**
 * Class SecurityController.
 */
class SecurityController
{
    /**
     * @Sensio\Route("/logout")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws \google\appengine\api\users\UsersException
     */
    public function logoutAction()
    {
        $url = UserService::createLogoutURL('/');

        return RedirectResponse::create($url, 307, array('cache-control' => 'no-cache'));
    }

    /**
     * @Sensio\Route("/login")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws \google\appengine\api\users\UsersException
     */
    public function loginAction()
    {
        $url = UserService::createLoginURL();

        return RedirectResponse::create($url, 307, array('cache-control' => 'no-cache'));
    }
}
