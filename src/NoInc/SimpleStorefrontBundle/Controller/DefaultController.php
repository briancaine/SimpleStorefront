<?php

namespace NoInc\SimpleStorefrontBundle\Controller;

use NoInc\SimpleStorefrontBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="guest_home")
     * @Method("GET")
     */
    public function getAction()
    {
        $service = $this->get('app.recipe_service');
        $recipes = $service->getRecipesAndIngredients();
        
        $renderData = [];
        
        $renderData['title'] = 'A Simple Storefront';
        $renderData['recipes'] = $recipes;
            
        return $this->render('NoIncSimpleStorefrontBundle:Default:index.html.twig', $renderData);
    }
    
    /**
     * @Route("/buy/{recipe_id}", name="buy_product")
     * @Method("POST")
     * @ParamConverter("recipe", class="NoIncSimpleStorefrontBundle:Recipe", options={"mapping": {"recipe_id": "id"}})
     */
    public function postBuyProductAction(Recipe $recipe)
    {
        $service = $this->get('app.recipe_service');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ( $recipe->getProducts()->count() > 0 )
        {
            $service->userBuyRecipe($user, $recipe);
        }
        
        return $this->redirectToRoute('guest_home');
    }
    
    
}
