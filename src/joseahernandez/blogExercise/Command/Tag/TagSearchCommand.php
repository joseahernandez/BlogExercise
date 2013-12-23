<?php

namespace joseahernandez\blogExercise\Command\Tag;

use Doctrine\ORM\EntityManager;
use joseahernandez\blogExercise\Command\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TagSearchCommand
 * @package joseahernandez\blogExercise\Command\Tag
 */
class TagSearchCommand extends BaseCommand
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
        $this->setName('tag:search')
            ->setDescription('Search tags')
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
            $tags = $this->em->getRepository('joseahernandez\blogExercise\Entity\Tag')->findAll();
        } else {
            $tags = $this->em->getRepository('joseahernandez\blogExercise\Entity\Tag')->findByName($name);
        }

        if (0 < count($tags)) {
            $this->printTags($tags, $output);
        } else {
            $output->writeln("No tags found");
        }

    }

    public function printTags(array $tags, OutputInterface $output)
    {
        foreach ($tags as $tag) {
            $output->writeln($tag->getName());
        }
    }
} 