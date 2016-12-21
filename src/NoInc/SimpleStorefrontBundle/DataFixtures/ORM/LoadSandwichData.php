<?php

namespace NoInc\SimpleStorefrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NoInc\SimpleStorefrontBundle\Entity\User;
use NoInc\SimpleStorefrontBundle\Entity\Ingredient;
use NoInc\SimpleStorefrontBundle\Entity\Recipe;
use NoInc\SimpleStorefrontBundle\Entity\RecipeIngredient;

class LoadSandwichData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ingredients = [];
        foreach ( $this->ingredientArray() as $ingredientData )
        {
            $ingredient = new Ingredient();
            
            $ingredient->setName($ingredientData["name"]);
            $ingredient->setPrice($ingredientData["price"]);
            $ingredient->setMeasure($ingredientData["measure"]);
            $ingredient->setStock(100);
    
            $manager->persist($ingredient);
        
            $ingredients[$ingredient->getName()] = $ingredient;
        }
        $manager->flush();
        
        $recipeData = $this->recipeArray();
        
        $recipe = new Recipe();
        $recipe->setName($recipeData["name"]);
        $recipe->setPrice($recipeData["price"]);
        $manager->persist($recipe);
        $manager->flush();
        
        foreach( $recipeData["ingredients"] as $recipeIngredientData )
        {
            $recipeIngredient = new RecipeIngredient();
            
            $recipeIngredient->setIngredient($ingredients[$recipeIngredientData["name"]]);
            $recipeIngredient->setRecipe($recipe);
            $recipeIngredient->setQuantity($recipeIngredientData["quantity"]);
            $manager->persist($recipeIngredient);
        }
        $manager->flush();
    }
    
    public function ingredientArray()
    {
        return [
            [
                "name" => "Bread",
                "price" => 0.50,
                "measure" => "Slice"
            ],
            [
                "name" => "Cheese",
                "price" => 0.10,
                "measure" => "Slice"
            ],
            [
                "name" => "Baloney",
                "price" => 0.15,
                "measure" => "Slice"
            ]
        ];
    }
    
    public function recipeArray()
    {
        return [
            "name" => "Sandwich",
            "price" => 1.50,
            "ingredients" => [
                [
                    "name" => "Bread",
                    "quantity" => 2
                ],
                [
                    "name" => "Cheese",
                    "quantity" => 1
                ],
                [
                    "name" => "Baloney",
                    "quantity" => 2
                ],
            ]
        ];
    }
    
    public function getOrder()
    {
        return 3;
    }
}