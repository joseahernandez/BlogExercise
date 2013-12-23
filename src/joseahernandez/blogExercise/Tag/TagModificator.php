<?php

namespace joseahernandez\blogExercise\Tag;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Entity\Tag;

/**
 * Class TagModificator
 * @package joseahernandez\blogExercise\Tag
 */
class TagModificator
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
     * @param Tag $tag
     * @param string $name
     *
     * @return Tag
     */
    public function updateName(Tag $tag, $name)
    {
        $tag->setName($name);

        return $this->update($tag);
    }

    /**
     * @param Tag $tag
     *
     * @return Tag
     */
    public function update(Tag $tag)
    {
        $this->em->persist($tag);
        $this->em->flush();

        return $tag;
    }
} 