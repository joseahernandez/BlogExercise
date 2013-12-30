<?php

namespace joseahernandez\blogExercise\Command\Article;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Article\ArticleCreator;
use joseahernandez\blogExercise\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ArticleCreateCommand
 * @package joseahernandez\blogExercise\Command\Article
 */
class ArticleCreateCommand extends BaseCommand
{
    /**
     * @var ArticleCreator
     */
    protected $articleCreator;

    /**
     * @param EntityManager $em
     * @param ArticleCreator $articleCreator
     */
    public function __construct(EntityManager $em, ArticleCreator $articleCreator)
    {
        parent::__construct($em);
        $this->articleCreator = $articleCreator;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('article:create')
            ->setDescription('Create a new article');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog  = $this->getHelper('dialog');
        $author  = $this->askUserForAuthor($output);
        $tags    = $this->askUserForTags($output);
        $title   = '';
        $content = '';

        while ('' === $title) {
            $title = $dialog->ask(
                $output,
                'Type the article\'s title: ',
                ''
            );

            $title = trim($title);
        }

        while ('' === $content) {
            $content = $dialog->ask(
                $output,
                'Type the article\'s content: ',
                ''
            );

            $content = trim($content);
        }

        try {
            $this->articleCreator->create($title, $content, $author, $tags);
            $output->writeln('<fg=green>Article created successfully</fg=green>');
        } catch (DBALException $e) {
            $output->writeln('<fg=red>Error creating the article: ' . $e->getMessage() . '</fg=red>');
        }
    }

    /**
     * @param OutputInterface $output
     *
     * @return Author|null
     */
    public function askUserForAuthor(OutputInterface $output)
    {
        $authorName = '';
        $author     = null;
        $dialog     = $this->getHelper('dialog');

        while (null === $author) {
            $authorName = $dialog->ask(
                $output,
                'Type the author name or empty to cancel: ',
                ''
            );

            if ('' === trim($authorName)) {
                return null;
            } else {
                $author = $this->em
                    ->getRepository('\joseahernandez\blogExercise\Entity\Author')
                    ->findOneByName($authorName);

                if (null !== $author) {
                    return $author;
                } else {
                    $output->writeln('<fg=red>Invalid name</fg=red>');
                }
            }
        }
    }

    /**
     * @param OutputInterface $output
     *
     * @return array
     */
    public function askUserForTags(OutputInterface $output)
    {
        $tags   = array();
        $dialog = $this->getHelper('dialog');

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

        return $tags;
    }
}