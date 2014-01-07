<?php

namespace joseahernandez\blogExercise\Command\Article;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Article\ArticleModificator;
use joseahernandez\blogExercise\Command\BaseCommand;
use joseahernandez\blogExercise\Entity\Article;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ArticleUpdateCommand
 * @package joseahernandez\blogExercise\Command\Article
 */
class ArticleUpdateCommand extends BaseCommand
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ArticleModificator
     */
    protected $articleModificator;

    /**
     * @param EntityManager      $em
     * @param ArticleModificator $articleModificator
     */
    public function __construct(EntityManager $em, ArticleModificator $articleModificator)
    {
        parent::__construct($em);
        $this->articleModificator = $articleModificator;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('article:update')
            ->setDescription('Update an article')
            ->addArgument(
                'id',
                InputArgument::REQUIRED
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $articleId = $input->getArgument('id');
        $article   = $this->em->getRepository('joseahernandez\blogExercise\Entity\Article')->find($articleId);

        if (null == $article) {
            $output->writeln('<fg=red>Not exists an article with id ' . $articleId . '</fg=red>');
        } else {
            $article = $this->askUserForArticleInformation($output, $article);

            $this->articleModificator->update($article);

            $output->writeln('<fg=green>Article updated successfully</fg=green>');
        }
    }

    /**
     * @param OutputInterface $output
     * @param Article         $article
     *
     * @return Article
     */
    public function askUserForArticleInformation(OutputInterface $output, Article $article)
    {
        $dialog = $this->getHelper('dialog');

        $author = $this->askAuthor($output);
        if (null === $author) {
            $author = $article->getAuthor();
        }

        $article->setAuthor($author);

        $tags = $this->askTags($output);
        if (null === $tags) {
            $tags = $article->getTags();
        }

        $article->setTags($tags);

        $title = $dialog->ask(
            $output,
            'Type the new title or empty to use the current: ',
            ''
        );

        if ('' === $title) {
            $title = $article->getTitle();
        }

        $article->setTitle($title);

        $content = $dialog->ask(
            $output,
            'Type the new content or empty to use the current: ',
            ''
        );

        if ('' === $content) {
            $content = $article->getContent();
        }

        $article->setContent($content);

        return $article;
    }

    /**
     * @param OutputInterface $output
     *
     * @return Author|null
     */
    private function askAuthor(OutputInterface $output)
    {
        $dialog = $this->getHelper('dialog');
        $author = null;

        while (null === $author) {
            $authorName = $dialog->ask(
                $output,
                'Type the author name or empty to use current author: ',
                ''
            );

            if ('' === trim($authorName)) {
                return null;
            }

            $author = $this->em
                ->getRepository('\joseahernandez\blogExercise\Entity\Author')
                ->findOneByName($authorName);

            if (null !== $author) {
                return $author;
            } else {
                $output->writeln('<fg=red>Invalid author name</fg=red>');
            }
        }

    }

    /**
     * @param OutputInterface $output
     *
     * @return null|array
     */
    private function askTags(OutputInterface $output)
    {
        $dialog   = $this->getHelper('dialog');
        $tags     = array();
        $editTags = '';

        do {
            $editTags = $dialog->ask(
                $output,
                'Do you want to edit all tags (y/n): ',
                ''
            );
        } while ('y' !== strtolower($editTags) && 'n' !== strtolower($editTags));

        if ('n' === strtolower($editTags)) {
            return null;
        }

        do {
            $tagName = $dialog->ask(
                $output,
                'Type tag name or empty to finish: ',
                ''
            );

            if ('' !== $tagName) {
                $tag = $this->em
                    ->getRepository('\joseahernandez\blogExercise\Entity\Tag')
                    ->findOneByName($tagName);

                if (null == $tag) {
                    $output->writeln('<fg=red>Invalid tag</fg=red>');
                } else {
                    $tags[] = $tag;
                    $output->writeln('<fg=green>Tag added</fg=green>');
                }
            }
        } while ('' !== $tagName);
    }
} 