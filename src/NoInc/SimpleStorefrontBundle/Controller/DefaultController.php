<?php

namespace NoInc\SimpleStorefrontBundle\Controller;

use NoInc\SimpleStorefrontBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="guest_home")
     * @Method("GET")
     */
    public function getAction(Request $request)
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

    /**
     * @Route("/shopping_cart", name="shopping_cart")
     * @Method("GET")
     */
    public function getShoppingCart()
    {
        $service = $this->get('app.shopping_cart_service');
        $cart = $service->getCurrentShoppingCart();

        $renderData = [];
        $renderData['title'] = 'Shopping Cart';
        $renderData['shopping_cart'] = $cart;

        return $this->render('NoIncSimpleStorefrontBundle:Default:shopping-cart.html.twig', $renderData); 
    }

    /**
     * @Route("/add_to_cart/{recipe_id}", name="add_to_cart")
     * @Method("POST")
     * @ParamConverter("recipe", class="NoIncSimpleStorefrontBundle:Recipe", options={"mapping": {"recipe_id": "id"}})
     */
    public function postAddToCartAction(Recipe $recipe)
    {
        $service = $this->get('app.shopping_cart_service');
        $cart = $service->getCurrentShoppingCart();
        $cart->addRecipe($recipe);
        $cart->save();

        return $this->redirectToRoute('guest_home');
    }

    /**
     * @Route("/remove_from_cart/{index}", name="remove_from_cart")
     * @Method("POST")
     */
    public function postRemoveFromCartAction($index)
    {
        $service = $this->get('app.shopping_cart_service');
        $cart = $service->getCurrentShoppingCart();
        $cart->removeItemByIndex($index);
        $cart->save();

        return $this->redirectToRoute('shopping_cart');
    }

    /**
     * @Route("/checkout", name="checkout_shopping_cart")
     * @Method("POST")
     */
    public function postCheckoutShoppingCartAction()
    {
        $recipe_service = $this->get('app.recipe_service');
        $service = $this->get('app.shopping_cart_service');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $service->getCurrentShoppingCart();

        $items = $cart->getCartItems();
        $current_index = 0;

        foreach ($items as $item) {
            $cart->removeItemByIndex($current_index);
            $recipe = $item->getRecipe();

            $current_index = $current_index + 1;
            $cart->save();
        }

        return $this->redirectToRoute('guest_home');
    }
}
