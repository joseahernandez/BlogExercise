<?php

namespace joseahernandez\blogExercise\Article;
use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Entity\Article;
use joseahernandez\blogExercise\Entity\Author;

/**
 * Class ArticleCreator
 * @package joseahernandez\blogExercise\Article
 */
class ArticleCreator
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
     * @param string $title
     * @param string $content
     * @param Author $author
     * @param array  $tags
     *
     * @return Article
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function create($title, $content, Author $author, array $tags = array())
    {
        $article = new Article();
        $article->setTitle($title);
        $article->setContent($content);
        $article->setAuthor($author);
        $article->setTags($tags);
        $article->setCreatedAt(new \DateTime());

        $this->em->persist($article);
        $this->em->flush();

        return $article;
    }
} 