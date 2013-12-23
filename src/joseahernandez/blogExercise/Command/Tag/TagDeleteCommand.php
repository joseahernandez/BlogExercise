<?php

namespace joseahernandez\blogExercise\Command\Tag;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Command\BaseCommand;
use joseahernandez\blogExercise\Tag\TagDeleter;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TagDeleteCommand
 * @package joseahernandez\blogExercise\Command\Tag
 */
class TagDeleteCommand extends BaseCommand
{
    /**
     * @var TagDeleter
     */
    protected $tagDeleter;

    /**
     * @param EntityManager $em
     * @param TagDeleter    $tagDeleter
     */
    public function __construct(EntityManager $em, TagDeleter $tagDeleter)
    {
        parent::__construct($em);
        $this->tagDeleter = $tagDeleter;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('tag:delete')
            ->setDescription('Delete a tag')
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

        if ($this->tagDeleter->deleteByName($name)) {
            $output->writeln('<fg=green>Tag deleted successfully</fg=green>');
        } else {
            $output->writeln('<fg=red>Not exists a tag with name ' . $name . '</fg=red>');
        }
    }
} 