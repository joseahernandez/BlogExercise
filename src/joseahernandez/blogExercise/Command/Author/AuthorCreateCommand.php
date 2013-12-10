<?php
namespace joseahernandez\blogExercise\Command\Author;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Author\AuthorCreator;
use joseahernandez\blogExercise\Command\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AuthorCreateCommand
 * @package joseahernandez\blogExercise\Command\Author
 */
class AuthorCreateCommand extends BaseCommand
{
    /**
     * @var AuthorCreator
     */
    protected $authorCreator;

    /**
     * @param EntityManager $em
     * @param AuthorCreator $authorCreator
     */
    public function __construct(EntityManager $em, AuthorCreator $authorCreator)
    {
        parent::__construct($em);
        $this->authorCreator = $authorCreator;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('author:create')
            ->setDescription('Create a new author')
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

        try {
            $author = $this->authorCreator->create($name);

            if (null !== $author) {
                $output->writeln('<fg=green>Author with name: ' . $author->getName() . ' created</fg=green>');
            } else {
                $output->writeln('<fg=red>Error creating the author</fg=red>');
            }
        } catch (DBALException $e) {
            $output->writeln('<fg=red>Exception throw creating the user</fg=red>');
        }
    }
} 