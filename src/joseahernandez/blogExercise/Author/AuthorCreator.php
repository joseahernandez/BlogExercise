<?php

namespace joseahernandez\blogExercise\Author;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Entity\Author;

/**
 * Class AuthorCreator
 * @package joseahernandez\blogExercise\Author
 */
class AuthorCreator
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
     * @param string $name
     *
     * @return Author
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function create($name)
    {
        $author = new Author();
        $author->setName($name);

        $this->em->persist($author);
        $this->em->flush();

        return $author;
    }
}