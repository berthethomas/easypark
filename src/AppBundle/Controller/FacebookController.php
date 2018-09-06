<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class FacebookController extends Controller {

    /**
     * Link to this controller to start the "connect" process
     *
     * @Route("/connect/facebook", name="login_facebook")
     */
    public function connectAction() {
        // will redirect to Facebook!
        return $this->get('oauth2.registry')
                        ->getClient('facebook_main') // key used in config.yml
                        ->redirect();
    }

    /**
     * After going to Facebook, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config.yml
     *
     * @Route("/connect/facebook/check", name="connect_facebook_check")
     */
    public function connectCheckAction(Request $request) {
        
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)

        /** @var \KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient $client */
        $client = $this->get('oauth2.registry')
                ->getClient('facebook_main');

        return $this->redirectToRoute('homepage');
    }

}
