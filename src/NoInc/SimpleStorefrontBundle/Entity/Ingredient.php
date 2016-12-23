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
 * NoInc\SimpleStorefrontBundle\Entity\Ingredient
 *
 * @ORM\Entity(repositoryClass="NoInc\SimpleStorefrontBundle\Repository\IngredientRepository")
 * @ORM\Table(name="ingredient")
 */
class Ingredient
{
    /**
     * ID of the Ingredient
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Name of the Ingredient
     *
     * @ORM\Column(name="`name`", type="string", length=45, nullable=false)
     */
    protected $name;

    /**
     * Price of the Ingredient
     *
     * @ORM\Column(type="float", nullable=false)
     */
    protected $price;

    /**
     * The unit of measure this Ingredient comes in.
     *
     * @ORM\Column(type="string", length=45, nullable=false)
     */
    protected $measure;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    protected $stock;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $ingredientcol;

    /**
     * @ORM\OneToMany(targetEntity="RecipeIngredient", mappedBy="ingredient")
     * @ORM\JoinColumn(name="id", referencedColumnName="ingredient_id", nullable=false)
     */
    protected $recipeIngredients;

    public function __construct()
    {
        $this->recipeIngredients = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \NoInc\SimpleStorefrontBundle\Entity\Ingredient
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
     * @return \NoInc\SimpleStorefrontBundle\Entity\Ingredient
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
     * @return \NoInc\SimpleStorefrontBundle\Entity\Ingredient
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
     * Set the value of measure.
     *
     * @param string $measure
     * @return \NoInc\SimpleStorefrontBundle\Entity\Ingredient
     */
    public function setMeasure($measure)
    {
        $this->measure = $measure;

        return $this;
    }

    /**
     * Get the value of measure.
     *
     * @return string
     */
    public function getMeasure()
    {
        return $this->measure;
    }

    /**
     * Set the value of stock.
     *
     * @param float $stock
     * @return \NoInc\SimpleStorefrontBundle\Entity\Ingredient
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get the value of stock.
     *
     * @return float
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set the value of ingredientcol.
     *
     * @param string $ingredientcol
     * @return \NoInc\SimpleStorefrontBundle\Entity\Ingredient
     */
    public function setIngredientcol($ingredientcol)
    {
        $this->ingredientcol = $ingredientcol;

        return $this;
    }

    /**
     * Get the value of ingredientcol.
     *
     * @return string
     */
    public function getIngredientcol()
    {
        return $this->ingredientcol;
    }

    /**
     * Add RecipeIngredient entity to collection (one to many).
     *
     * @param \NoInc\SimpleStorefrontBundle\Entity\RecipeIngredient $recipeIngredient
     * @return \NoInc\SimpleStorefrontBundle\Entity\Ingredient
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
     * @return \NoInc\SimpleStorefrontBundle\Entity\Ingredient
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

    public function canAfford($user) {
        return $user->getCapital() >= $this->getPrice();
    }

    public function __sleep()
    {
        return array('id', 'name', 'price', 'measure', 'stock', 'ingredientcol');
    }
}
