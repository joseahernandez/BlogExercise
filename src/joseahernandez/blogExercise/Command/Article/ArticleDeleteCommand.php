<?php

namespace joseahernandez\blogExercise\Command\Article;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Article\ArticleDeleter;
use joseahernandez\blogExercise\Command\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ArticleDeleteCommand
 * @package joseahernandez\blogExercise\Command\Article
 */
class ArticleDeleteCommand extends BaseCommand
{
    /**
     * @var ArticleDeleter
     */
    protected $articleDeleter;

    /**
     * @param EntityManager  $em
     * @param ArticleDeleter $articleDeleter
     */
    public function __construct(EntityManager $em, ArticleDeleter $articleDeleter)
    {
        parent::__construct($em);
        $this->articleDeleter = $articleDeleter;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('article:delete')
            ->setDescription('Delete an article')
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
        $id = $input->getArgument('id');

        if ($this->articleDeleter->deleteById($id)) {
            $output->writeln('<fg=green>Article deleted successfully</fg=green>');
        } else {
            $output->writeln('<fg=red>Not exists an article with id ' . $id . '</fg=red>');
        }
    }
} 