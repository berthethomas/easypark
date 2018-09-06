<?php

namespace AppBundle\Security;

use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use AppBundle\Entity\User;

class FacebookAuthenticator extends SocialAuthenticator {

    private $clientRegistry;
    private $em;
    private $router;
    private $ENCRYPT_TOKEN = "bi3Hhph71VTs1GreDo8g";

    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $em, RouterInterface $router) {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->router = $router;
    }

    public function supports(Request $request) {
        // continue ONLY if the current ROUTE matches the check ROUTE
        return $request->attributes->get('_route') === 'connect_facebook_check';
    }

    public function getCredentials(Request $request) {
        return $this->fetchAccessToken($this->getFacebookClient());
    }

    public function getUser($credentials, UserProviderInterface $userProvider) {
        /** @var FacebookUser $facebookUser */
        $facebookUser = $this->getFacebookClient()
                ->fetchUserFromToken($credentials);

        $email = $facebookUser->getEmail();

        // 1) have they logged in with Facebook before? Easy!
        $existingUser = $this->em->getRepository('AppBundle:User')
                ->findOneBy(['facebookId' => $facebookUser->getId()]);
        if ($existingUser) {
            return $existingUser;
        }

        // 2) do we have a matching user by email?
        $user = $this->em->getRepository('AppBundle:User')
                ->findOneBy(['email' => $email]);

        if ($user == NULL) {
            $user = new User();
            $user->setEmail($facebookUser->getEmail());
            $user->setUsername($facebookUser->getEmail());
            $user->setUsernameCanonical($facebookUser->getEmail());
            $user->setNom($facebookUser->getLastName());
            $user->setPrenom($facebookUser->getFirstName());
            $user->setPassword($this->hash($facebookUser->getId()));
            $user->setEnabled(TRUE);
        }

// 3) Maybe you just want to "register" them by creating
        // a User object
        $user->setFacebookId($facebookUser->getId());
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @return FacebookClient
     */
    private function getFacebookClient() {
        return $this->clientRegistry
                        // "facebook_main" is the key used in config.yml
                        ->getClient('facebook_main');
    }

    public function onAuthenticationFailure(\Symfony\Component\HttpFoundation\Request $request, \Symfony\Component\Security\Core\Exception\AuthenticationException $exception) {
        
    }

    public function onAuthenticationSuccess(\Symfony\Component\HttpFoundation\Request $request, \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token, $providerKey) {
        
    }

    public function start(\Symfony\Component\HttpFoundation\Request $request, \Symfony\Component\Security\Core\Exception\AuthenticationException $authException = null) {
        
    }

    private function hash($string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $iv = substr(hash('sha256', md5($this->ENCRYPT_TOKEN)), 0, 16);
        $key = hash('sha256', $this->ENCRYPT_TOKEN);

        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));

        return $output;
    }

}
