<?php

namespace NoInc\SimpleStorefrontBundle\Services;

use NoInc\SimpleStorefrontBundle\Entity\Ingredient;
use NoInc\SimpleStorefrontBundle\Entity\User;
use NoInc\SimpleStorefrontBundle\Repository\IngredientRepository;
use Doctrine\ORM\EntityManager;

class IngredientService
{
    protected $em;
    protected $repo;

    public function __construct(EntityManager $em, IngredientRepository $repo) {
        $this->em = $em;
        $this->repo = $repo;
    }

    public function canUserAfford(User $user, Ingredient $ingredient) {
        return $user->getCapital() >= $ingredient->getPrice();
    }

    public function buyUserIngredient(User $user, Ingredient $ingredient) {
        $user->setCapital($user->getCapital() - $ingredient->getPrice());
        $ingredient->setStock($ingredient->getStock() + 1);
        $this->em->persist($user);
        $this->em->persist($ingredient);
        $this->em->flush();
    }

    public function getIngredients() {
        return $this->repo->getIngredients();
    }
}
