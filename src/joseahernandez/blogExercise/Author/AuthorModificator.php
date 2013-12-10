<?php

namespace joseahernandez\blogExercise\Author;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Entity\Author;

/**
 * Class AuthorModificator
 * @package joseahernandez\blogExercise\Author
 */
class AuthorModificator
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Author $author
     * @param string $name
     *
     * @return Author
     */
    public function updateName(Author $author, $name)
    {
        $author->setName($name);

        return $this->update($author);
    }

    /**
     * @param Author $author
     *
     * @return Author
     */
    public function update(Author $author)
    {
        $this->em->persist($author);
        $this->em->flush();

        return $author;
    }
} 