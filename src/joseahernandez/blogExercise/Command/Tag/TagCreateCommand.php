<?php

namespace joseahernandez\blogExercise\Command\Tag;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Command\BaseCommand;
use joseahernandez\blogExercise\Tag\TagCreator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TagCreateCommand
 * @package joseahernandez\blogExercise\Command\Tag
 */
class TagCreateCommand extends BaseCommand
{

    /**
     * @var TagCreator
     */
    protected $tagCreator;

    /**
     * @param EntityManager $em
     * @param TagCreator    $tagCreator
     */
    public function __construct(EntityManager $em, TagCreator $tagCreator)
    {
        parent::__construct($em);
        $this->tagCreator = $tagCreator;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('tag:create')
            ->setDescription('Create a new tag')
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
            $tag = $this->tagCreator->create($name);

            if (null !== $tag) {
                $output->writeln('<fg=green>Tag: ' . $tag->getName() . ' created</fg=green>');
            } else {
                $output->writeln('<fg=red>Error creating the tag</fg=red>');
            }
        } catch (DBALException $e) {
            $output->writeln('<fg=red>Exception throw creating the tag</fg=red>');
        }
    }
} 