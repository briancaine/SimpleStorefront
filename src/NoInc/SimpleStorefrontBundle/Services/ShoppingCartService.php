<?php

namespace NoInc\SimpleStorefrontBundle\Services;

use NoInc\SimpleStorefrontBundle\Entity\ShoppingCart;
use NoInc\SimpleStorefrontBundle\Entity\SessionShoppingCart;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManager;

class ShoppingCartService
{
    protected $request_stack;
    protected $em;
    protected $token_storage;

    public function __construct(RequestStack $request_stack,
                                EntityManager $em,
                                TokenStorageInterface $token_storage) {
        $this->request_stack = $request_stack;
        $this->em = $em;
        $this->token_storage = $token_storage;
    }

    public function getCurrentShoppingCart() {
        $request = $this->request_stack->getCurrentRequest();
        $session = $request->getSession();
        $token = $this->token_storage->getToken();
        $user = $token->getUser();

        /* for now, if there's a user, we're using database shopping carts */
        if ($token && $user != "anon.") {
            $user->setEntityManager($this->em);
            return $user;
        }

        if (!$session) { $session = new Session(); }

        return new SessionShoppingCart($session, $this->em);
    }
}
