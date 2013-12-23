<?php

namespace joseahernandez\blogExercise\Tag;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Entity\Tag;

/**
 * Class TagDeleter
 * @package joseahernandez\blogExercise\Tag
 */
class TagDeleter
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
        $tag = $this->em
            ->getRepository('\joseahernandez\blogExercise\Entity\Tag')
            ->findOneByName($name);

        if (null !== $tag) {
            return $this->delete($tag);
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
        $tag = $this->em
            ->getRepository('\joseahernandez\blogExercise\Entity\Tag')
            ->find($id);

        if (null !== $tag) {
            return $this->delete($tag);
        }

        return false;
    }

    /**
     * @param Tag $tag
     *
     * @return bool
     */
    public function delete(Tag $tag)
    {
        $this->em->remove($tag);
        $this->em->flush();

        return true;
    }
} 