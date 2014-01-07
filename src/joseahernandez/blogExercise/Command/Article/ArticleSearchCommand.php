<?php

namespace joseahernandez\blogExercise\Command\Article;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Command\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ArticleSearchCommand extends BaseCommand
{
    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('article:search')
            ->setDescription('Search articles')
            ->addArgument(
                'id',
                InputArgument::OPTIONAL
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $articleId = $input->getArgument('id');

        if (null === $articleId) {
            $articles = $this->em->getRepository('joseahernandez\blogExercise\Entity\Article')->findAll();
        } else {
            $articles = $this->em->getRepository('joseahernandez\blogExercise\Entity\Article')->find($articleId);
            if (null === $articles) {
                $output->writeln("<fg=red>Invalid article id</fg=red>");
                return;
            }
            $articles = array($articles);
        }

        if (0 < count($articles)) {
            $this->printArticles($articles, $output);
        } else {
            $output->writeln("No authors found");
        }
    }

    /**
     * @param array           $articles
     * @param OutputInterface $output
     */
    private function printArticles(array $articles, OutputInterface $output)
    {
        foreach ($articles as $article) {
            $output->writeln('################################################################################');
            $output->writeln($article->getTitle());
            $output->writeln(
                'Created by: ' . $article->getAuthor()->getName() .
                ' on ' . $article->getCreatedAt()->format('d/m/Y')
            );
            $output->writeln('--------------------------------------------------------------------------------');
            $output->writeln($article->getContent());
            $output->writeln('################################################################################');
            $output->writeln('');
        }
    }
} 