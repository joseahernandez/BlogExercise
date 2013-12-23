<?php

namespace joseahernandez\blogExercise\Command\Author;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Author\AuthorDeleter;
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
     * @var AuthorDeleter
     */
    protected $authorDeleter;

    /**
     * @param EntityManager $em
     * @param AuthorDeleter $authorDeleter
     */
    public function __construct(EntityManager $em, AuthorDeleter $authorDeleter)
    {
        parent::__construct($em);
        $this->authorDeleter = $authorDeleter;
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

        if ($this->authorDeleter->deleteByName($name)) {
            $output->writeln('<fg=green>Author deleted successfully</fg=green>');
        } else {
            $output->writeln('<fg=red>Not exists an author with name ' . $name . '</fg=red>');
        }
    }
} 