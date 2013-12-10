<?php

namespace joseahernandez\blogExercise\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;

abstract class BaseCommand extends Command
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        parent::__construct();
        $this->em = $em;
    }
} 