<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 3.0.2 (doctrine2-annotation) on 2016-12-29 19:59:55.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace NoInc\SimpleStorefrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NoInc\SimpleStorefrontBundle\Entity\ORMCartItem
 *
 * @ORM\Entity(repositoryClass="NoInc\SimpleStorefrontBundle\Repository\ORMCartItemRepository")
 * @ORM\Table(name="orm_cart_item")
 */
class ORMCartItem
{
    protected $index;

    public function setIndex($index) { $this->index = $index; return $this; }
    public function getIndex() { return $this->index; }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=45, nullable=false)
     */
    protected $recipe_id;

    /**
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="products")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id", nullable=false)
     */
    protected $recipe;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="products")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \NoInc\SimpleStorefrontBundle\Entity\ORMCartItem
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
     * Set the value of recipe_id.
     *
     * @param string $recipe_id
     * @return \NoInc\SimpleStorefrontBundle\Entity\OrmCartItem
     */
    public function setRecipeId($recipe_id)
    {
        $this->recipe_id = $recipe_id;

        return $this;
    }

    /**
     * Get the value of recipe_id.
     *
     * @return string
     */
    public function getRecipeId()
    {
        return $this->recipe_id;
    }

    /**
     * Set Recipe entity (many to one).
     *
     * @param \NoInc\SimpleStorefrontBundle\Entity\Recipe $recipe
     * @return \NoInc\SimpleStorefrontBundle\Entity\Product
     */
    public function setRecipe(Recipe $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get Recipe entity (many to one).
     *
     * @return \NoInc\SimpleStorefrontBundle\Entity\Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set User entity (many to one).
     *
     * @param \NoInc\SimpleStorefrontBundle\Entity\User $user
     * @return \NoInc\SimpleStorefrontBundle\Entity\Product
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get User entity (many to one).
     *
     * @return \NoInc\SimpleStorefrontBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __sleep()
    {
        return array('id', 'recipe_id', 'user_id');
    }
}