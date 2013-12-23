<?php

namespace joseahernandez\blogExercise\Command\Tag;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Command\BaseCommand;
use joseahernandez\blogExercise\Tag\TagModificator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TagUpdateCommand
 * @package joseahernandez\blogExercise\Command\Tag
 */
class TagUpdateCommand extends BaseCommand
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var TagModificator
     */
    protected $tagModificator;

    /**
     * @param EntityManager     $em
     * @param TagModificator    $tagModificator
     */
    public function __construct(EntityManager $em, TagModificator $tagModificator)
    {
        parent::__construct($em);
        $this->tagModificator = $tagModificator;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('tag:update')
            ->setDescription('Update the name of the tag')
            ->addArgument(
                'currentName',
                InputArgument::REQUIRED,
                'Current name of the tag'
            )
            ->addArgument(
                'newName',
                InputArgument::REQUIRED,
                'New name of the tag'
            );

    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currentName = $input->getArgument('currentName');
        $newName     = $input->getArgument('newName');

        $tag = $this->em->getRepository('joseahernandez\blogExercise\Entity\Tag')->findOneByName($currentName);

        if (null === $tag) {
            $output->writeln('<fg=red>Not exists a tag with name ' . $currentName . '</fg=red>');
        } else {
            $this->tagModificator->updateName($tag, $newName);
            $output->writeln('<fg=green>Tag updated successfully</fg=green>');
        }
    }
} 