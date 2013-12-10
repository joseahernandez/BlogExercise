<?php

namespace joseahernandez\blogExercise\Command\Author;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Author\AuthorModificator;
use joseahernandez\blogExercise\Command\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AuthorUpdateCommand
 * @package joseahernandez\blogExercise\Command\Author
 */
class AuthorUpdateCommand extends BaseCommand
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var AuthorModificator
     */
    protected $authorModificator;

    /**
     * @param EntityManager     $em
     * @param AuthorModificator $authorModificator
     */
    public function __construct(EntityManager $em, AuthorModificator $authorModificator)
    {
        parent::__construct($em);
        $this->authorModificator = $authorModificator;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('author:update')
            ->setDescription('Update the name of the author')
            ->addArgument(
                'currentName',
                InputArgument::REQUIRED,
                'Current name of the author'
            )
            ->addArgument(
                'newName',
                InputArgument::REQUIRED,
                'New name of the author'
            );

    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currentName = $input->getArgument('currentName');
        $newName     = $input->getArgument('newName');

        $author = $this->em->getRepository('joseahernandez\blogExercise\Entity\Author')->findOneByName($currentName);

        if (null == $author) {
            $output->writeln('<fg=red>Not exists an author with name ' . $currentName . '</fg=red>');
        } else {
            $this->authorModificator->updateName($author, $newName);
            $output->writeln('<fg=green>Author updated successfully</fg=green>');
        }
    }
} 