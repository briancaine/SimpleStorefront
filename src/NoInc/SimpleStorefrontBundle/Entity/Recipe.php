<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 3.0.2 (doctrine2-annotation) on 2016-05-02 04:02:02.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace NoInc\SimpleStorefrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * NoInc\SimpleStorefrontBundle\Entity\Recipe
 *
 * @ORM\Entity(repositoryClass="NoInc\SimpleStorefrontBundle\Repository\RecipeRepository")
 * @ORM\Table(name="recipe")
 */
class Recipe
{
    /**
     * ID of the recipe
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Name of the recipe
     *
     * @ORM\Column(name="`name`", type="string", length=45, nullable=false)
     */
    protected $name;

    /**
     * Price of the Recipe's Products
     *
     * @ORM\Column(type="float", nullable=false)
     */
    protected $price;

    /**
     * Image URL
     *
     * @ORM\Column(name="`image_url`", type="string", nullable=false)
     */
    protected $image_url;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="recipe")
     * @ORM\JoinColumn(name="id", referencedColumnName="recipe_id", nullable=false)
     */
    protected $products;

    /**
     * @ORM\OneToMany(targetEntity="RecipeIngredient", mappedBy="recipe")
     * @ORM\JoinColumn(name="id", referencedColumnName="recipe_id", nullable=false)
     */
    protected $recipeIngredients;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->recipeIngredients = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \NoInc\SimpleStorefrontBundle\Entity\Recipe
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     * @return \NoInc\SimpleStorefrontBundle\Entity\Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of price.
     *
     * @param float $price
     * @return \NoInc\SimpleStorefrontBundle\Entity\Recipe
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of image_url.
     *
     * @param string $image_url
     * @return \NoInc\SimpleStorefrontBundle\Entity\Product
     */
    public function setImageURL($image_url)
    {
        $this->image_url = $image_url;

        return $this;
    }

    /**
     * Get the value of image_url.
     *
     * @return string
     */
    public function getImageURL()
    {
        return $this->image_url;
    }

    /**
     * Add Product entity to collection (one to many).
     *
     * @param \NoInc\SimpleStorefrontBundle\Entity\Product $product
     * @return \NoInc\SimpleStorefrontBundle\Entity\Recipe
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove Product entity from collection (one to many).
     *
     * @param \NoInc\SimpleStorefrontBundle\Entity\Product $product
     * @return \NoInc\SimpleStorefrontBundle\Entity\Recipe
     */
    public function removeProduct(Product $product)
    {
        $this->products->removeElement($product);

        return $this;
    }

    /**
     * Get Product entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Add RecipeIngredient entity to collection (one to many).
     *
     * @param \NoInc\SimpleStorefrontBundle\Entity\RecipeIngredient $recipeIngredient
     * @return \NoInc\SimpleStorefrontBundle\Entity\Recipe
     */
    public function addRecipeIngredient(RecipeIngredient $recipeIngredient)
    {
        $this->recipeIngredients[] = $recipeIngredient;

        return $this;
    }

    /**
     * Remove RecipeIngredient entity from collection (one to many).
     *
     * @param \NoInc\SimpleStorefrontBundle\Entity\RecipeIngredient $recipeIngredient
     * @return \NoInc\SimpleStorefrontBundle\Entity\Recipe
     */
    public function removeRecipeIngredient(RecipeIngredient $recipeIngredient)
    {
        $this->recipeIngredients->removeElement($recipeIngredient);

        return $this;
    }

    /**
     * Get RecipeIngredient entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipeIngredients()
    {
        return $this->recipeIngredients;
    }

    public function ingredientsAvailable()
    {
        foreach ($this->getRecipeIngredients() as $recipeIngredient)
        {
            $ingredient = $recipeIngredient->getIngredient();
            if ($ingredient->getStock() < $recipeIngredient->getQuantity()) {
                return false;
            }
        }
        return true;
    }

    public function __sleep()
    {
        return array('id', 'name', 'price', 'image_url');
    }
}
