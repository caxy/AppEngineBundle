<?php

namespace Caxy\Bundle\AppEngineBundle\Controller;

use google\appengine\api\users\UserService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SecurityController.
 */
class SecurityController
{
    /**
     * @Sensio\Route("/logout")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws \google\appengine\api\users\UsersException
     */
    public function logoutAction(Request $request)
    {
        $destination = $request->query->get('destination', '/');

        $url = UserService::createLogoutURL($destination);

        return RedirectResponse::create($url, 307, array('cache-control' => 'no-cache'));
    }

    /**
     * @Sensio\Route("/login")
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws \google\appengine\api\users\UsersException
     */
    public function loginAction(Request $request)
    {
        $destination = $request->query->get('destination', null);

        $url = UserService::createLoginURL($destination);

        return RedirectResponse::create($url, 307, array('cache-control' => 'no-cache'));
    }
}
