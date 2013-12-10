<?php

namespace joseahernandez\blogExercise\Author;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Entity\Author;

/**
 * Class AuthorDeleter
 * @package joseahernandez\blogExercise\Author
 */
class AuthorDeleter
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
     * @return bool
     */
    public function deleteByName($name)
    {
        $author = $this->em
            ->getRepository('\joseahernandez\blogExercise\Author')
            ->findOneByName($name);

        return $this->delete($author);
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function deleteById($id)
    {
        $author = $this->em
            ->getRepository('\joseahernandez\blogExercise\Author')
            ->find($id);

        return $this->delete($author);
    }

    /**
     * @param Author $author
     *
     * @return bool
     */
    public function delete(Author $author)
    {
        $this->em->remove($author);
        $this->flush();

        return true;
    }
} 