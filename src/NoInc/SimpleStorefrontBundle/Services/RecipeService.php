<?php

namespace NoInc\SimpleStorefrontBundle\Services;

use NoInc\SimpleStorefrontBundle\Entity\Recipe;
use NoInc\SimpleStorefrontBundle\Entity\Product;
use NoInc\SimpleStorefrontBundle\Entity\User;
use NoInc\SimpleStorefrontBundle\Repository\RecipeRepository;
use Doctrine\ORM\EntityManager;

class RecipeService
{
    protected $em;
    protected $repo;

    public function __construct(EntityManager $em, RecipeRepository $repo) {
        $this->em = $em;
        $this->repo = $repo;
    }

    public function ingredientsAvailable(Recipe $recipe) {
        return $recipe->ingredientsAvailable();
    }

    public function reduceIngredientStock(Recipe $recipe) {
        foreach ($recipe->getRecipeIngredients() as $recipeIngredient) {
            $ingredient = $recipeIngredient->getIngredient();
            $ingredient->setStock($ingredient->getStock() - $recipeIngredient->getQuantity());
            $this->em->persist($ingredient);
        }
    }

    public function userMakeRecipe(User $user, Recipe $recipe) {
        $product = new Product();
        $product->setCreatedAt(time());
        $product->setRecipe($recipe);
        $product->setUser($user);
        $this->em->persist($product);

        $this->reduceIngredientStock($recipe);

        $this->em->flush();
    }

    public function userBuyRecipe($user, Recipe $recipe) {
        $product = $recipe->getProducts()->first();
        $maker = $product->getUser();
        $maker->setCapital($maker->getCapital() + $product->getRecipe()->getPrice());
        $this->em->remove($product);
        $this->em->persist($maker);
        $this->em->flush();
    }

    public function getRecipesAndIngredients() {
        return $this->repo->getRecipesAndIngredients();
    }
}
