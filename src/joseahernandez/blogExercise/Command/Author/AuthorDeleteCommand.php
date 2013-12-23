<?php

namespace joseahernandez\blogExercise\Command\Author;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Command\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AuthorDeleteCommand
 * @package joseahernandez\blogExercise\Command\Author
 */
class AuthorDeleteCommand extends BaseCommand
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
        $this->setName('author:delete')
            ->setDescription('Delete an author')
            ->addArgument(
                'name',
                InputArgument::REQUIRED
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $author = $this->em->getRepository('joseahernandez\blogExercise\Entity\Author')->findOneByName($name);

        if (null == $author) {
            $output->writeln('<fg=red>Not exists an author with name ' . $name . '</fg=red>');
        } else {
            $this->em->remove($author);
            $this->em->flush();

            $output->writeln('<fg=green>Author deleted successfully</fg=green>');
        }

    }
} 