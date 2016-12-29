<?php

namespace NoInc\SimpleStorefrontBundle\Entity;

use NoInc\SimpleStorefrontBundle\Entity\SessionCartItem;
use Doctrine\ORM\EntityManager;

class SessionCartItem
{
    protected $em;
    protected $index;

    public function __construct($element, EntityManager $em) {
        $this->recipe_id = $element['recipe_id'];
        $this->em = $em;
    }

    public function getRecipeId() {
        return $this->recipe_id;
    }

    public function setRecipeId($recipe_id) {
        $this->recipe_id = $recipe_id;
        return $this;
    }

    public function getRecipe() {
        return $this->em->find('NoInc\SimpleStorefrontBundle\Entity\Recipe', $this->recipe_id);
    }

    public function setIndex($index) { $this->index = $index; return $this; }
    public function getIndex() { return $this->index; }

    public function asSessionData() {
        return array('recipe_id' => $this->recipe_id);
    }
}
