<?php

namespace joseahernandez\blogExercise\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Author
 * @package joseahernandez\blogExercise
 *
 * @ORM\Entity
 * @ORM\Table(name="author")
 */
class Author
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="name", unique=true)
     */
    protected $name;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
} 