<?php
namespace joseahernandez\blogExercise\Tag;
use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Entity\Tag;

/**
 * Class TagCreator
 * @package joseahernandez\blogExercise\Tag
 */
class TagCreator
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
     * @return Tag
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function create($name)
    {
        $tag = new Tag();
        $tag->setName($name);

        $this->em->persist($tag);
        $this->em->flush();

        return $tag;
    }
} 