<?php

namespace joseahernandez\blogExercise\Article;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Entity\Article;
use joseahernandez\blogExercise\Entity\Author;

/**
 * Class ArticleModificator
 * @package joseahernandez\blogExercise\Article
 */
class ArticleModificator
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
     * @param Article $article
     *
     * @return Article
     */
    public function update(Article $article)
    {
        $this->em->persist($article);
        $this->em->flush();

        return $article;
    }
} 