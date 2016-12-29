<?php

namespace NoInc\SimpleStorefrontBundle\Services;

use NoInc\SimpleStorefrontBundle\Entity\ShoppingCart;
use NoInc\SimpleStorefrontBundle\Entity\SessionShoppingCart;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;

class ShoppingCartService
{
    protected $request_stack;
    protected $em;

    public function __construct(RequestStack $request_stack, EntityManager $em) {
        $this->request_stack = $request_stack;
        $this->em = $em;
    }

    public function getCurrentShoppingCart() {
        $request = $this->request_stack->getCurrentRequest();
        $session = $request->getSession();

        if (!$session) { $session = new Session(); }

        if ($session && $session->has('shopping_cart')) {
            return new SessionShoppingCart($session, $this->em);
        }
        else {
            // default to session shopping carts for the time being
            return new SessionShoppingCart($session, $this->em);
        }
    }
}
