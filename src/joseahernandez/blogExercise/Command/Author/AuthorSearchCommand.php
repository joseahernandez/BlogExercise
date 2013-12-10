<?php

namespace joseahernandez\blogExercise\Command\Author;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Command\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AuthorSearchCommand extends BaseCommand
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
        $this->setName('author:search')
            ->setDescription('Search authors')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        if (null === $name) {
            $authors = $this->em->getRepository('joseahernandez\blogExercise\Entity\Author')->findAll();
        } else {
            $authors = $this->em->getRepository('joseahernandez\blogExercise\Entity\Author')->findByName($name);
        }

        if (0 < count($authors)) {
            $this->printAuthors($authors, $output);
        } else {
            $output->writeln("No authors found");
        }

    }

    public function printAuthors(array $authors, OutputInterface $output)
    {
        foreach ($authors as $author) {
            $output->writeln($author->getName());
        }
    }
} 