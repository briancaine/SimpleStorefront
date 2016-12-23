<?php

namespace NoInc\SimpleStorefrontBundle\Controller;

use NoInc\SimpleStorefrontBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NoInc\SimpleStorefrontBundle\Entity\Ingredient;
use NoInc\SimpleStorefrontBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_home")
     * @Method("GET")
     */
    public function getAction()
    {
        $recipes = $this->getDoctrine()->getRepository('NoIncSimpleStorefrontBundle:Recipe')->getRecipesAndIngredients();
        
        $renderData = [];
        
        $renderData['title'] = 'A Simple Storefront';
        $renderData['recipes'] = $recipes;
            
        return $this->render('NoIncSimpleStorefrontBundle:Default:admin.html.twig', $renderData);
    }
    
    /**
     * @Route("/make/{recipe_id}", name="make_recipe")
     * @Method("POST")
     * @ParamConverter("recipe", class="NoIncSimpleStorefrontBundle:Recipe", options={"mapping": {"recipe_id": "id"}})
     */
    public function postMakeRecipeAction(Recipe $recipe)
    {
        if (!$recipe->ingredientsAvailable()) {
            throw new Exception("Not all ingredients available");
        }

        $product = new Product();
        $product->setCreatedAt(time());
        $product->setRecipe($recipe);
        $product->setUser($this->get('security.token_storage')->getToken()->getUser());
        $this->getDoctrine()->getEntityManager()->persist($product);

        $recipe->reduceIngredientStock($this->getDoctrine()->getEntityManager());

        $this->getDoctrine()->getEntityManager()->flush();

        return $this->redirectToRoute('admin_home');
    }
    
    /**
     * @Route("/buy/{ingredient_id}", name="buy_ingredient")
     * @Method("POST")
     * @ParamConverter("ingredient", class="NoIncSimpleStorefrontBundle:Ingredient", options={"mapping": {"ingredient_id": "id"}})
     */
    public function postBuyIngredientAction(Ingredient $ingredient)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if (!$ingredient->canAfford($user)) {
            throw new Exception("User can't afford ingredient");
        }
        $user->setCapital($user->getCapital() - $ingredient->getPrice());
        $ingredient->setStock($ingredient->getStock() + 1);
        $this->getDoctrine()->getEntityManager()->persist($user);
        $this->getDoctrine()->getEntityManager()->persist($ingredient);
        $this->getDoctrine()->getEntityManager()->flush();
        return $this->redirectToRoute('admin_ingredients');
    }

    /**
     * @Route("/ingredients", name="admin_ingredients")
     * @Method("GET")
     */
    public function getIngredientsAction() {
        $ingredients = $this->getDoctrine()->getRepository('NoIncSimpleStorefrontBundle:Ingredient')->getIngredients();
        $renderData = [];
        $renderData['title'] = 'A Simple Storefront';
        $renderData['ingredients'] = $ingredients;

        return $this->render('NoIncSimpleStorefrontBundle:Default:ingredients.html.twig', $renderData);
    }
}
