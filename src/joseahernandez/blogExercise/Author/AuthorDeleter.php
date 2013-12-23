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
            ->getRepository('\joseahernandez\blogExercise\Entity\Author')
            ->findOneByName($name);

        if (null !== $author) {
            return $this->delete($author);
        }

        return false;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function deleteById($id)
    {
        $author = $this->em
            ->getRepository('\joseahernandez\blogExercise\Entity\Author')
            ->find($id);

        if (null !== $author) {
            return $this->delete($author);
        }

        return false;
    }

    /**
     * @param Author $author
     *
     * @return bool
     */
    public function delete(Author $author)
    {
        $this->em->remove($author);
        $this->em->flush();

        return true;
    }
} 