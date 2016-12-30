<?php

namespace NoInc\SimpleStorefrontBundle\Entity;

use NoInc\SimpleStorefrontBundle\Entity\ShoppingCart;
use NoInc\SimpleStorefrontBundle\Entity\SessionCartItem;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;

class SessionShoppingCart extends ShoppingCart
{
    protected $session;
    protected $em;

    public function __construct(Session $session, EntityManager $em) {
        $this->session = $session;
        $this->em = $em;
    }

    public function getCartItems() {
        $items = [];
        if ($this->session->has('shopping_cart')) {
            $items = $this->session->get('shopping_cart');
        }
        $res = [];
        $current_index = 0;
        foreach ($items as $item) {
            $next_item = new SessionCartItem($item, $this->em);
            $next_item->setIndex($current_index);
            $current_index = $current_index + 1;
            $res[] = $next_item;
        }
        return $res;
    }

    public function addCartItem(SessionCartItem $item) {
        $items = $this->session->get('shopping_cart');
        $items[] = $item->asSessionData();
        $this->session->set('shopping_cart', $items);
        return $this;
    }

    public function addRecipe(Recipe $recipe) {
        $item = new SessionCartItem(array('recipe_id' => $recipe->getId()), $this->em);
        $this->addCartItem($item);
    }

    public function removeItemByIndex($index) {
        $items = $this->session->get('shopping_cart');
        unset($items[$index]);
        $this->session->set('shopping_cart', array_values($items));
    }

    public function save() {
        // nothing to be done here
    }
}
