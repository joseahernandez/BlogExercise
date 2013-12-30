<?php

namespace joseahernandez\blogExercise\Article;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Entity\Article;

/**
 * Class ArticleDeleter
 * @package joseahernandez\blogExercise\Article
 */
class ArticleDeleter
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
     * @param int $id
     *
     * @return bool
     */
    public function deleteById($id)
    {
        $article = $this->em
            ->getRepository('\joseahernandez\blogExercise\Entity\Article')
            ->find($id);

        if (null !== $article) {
            return $this->delete($article);
        }

        return false;
    }

    /**
     * @param Article $article
     *
     * @return bool
     */
    public function delete(Article $article)
    {
        $this->em->remove($article);
        $this->em->flush();

        return true;
    }
} 