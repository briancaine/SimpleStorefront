<?php

namespace NoInc\SimpleStorefrontBundle\Entity;

use NoInc\SimpleStorefrontBundle\Entity\Recipe;

class ShoppingCart
{
    public function getCartItems() {
        return [];
    }

    public function isPluralCount() {
        return count($this->getCartItems()) != 1;
    }

    public function getTotalPrice() {
        $total = 0;
        foreach ($this->getCartItems() as $item) {
            $total = $total + $item->getRecipe()->getPrice();
        }
        return $total;
    }
}
