<?php

use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use \Symfony\Component\Console\Input\InputArgument;

class PrimeFactorCommand extends Command
{
    protected $primeFactors;

    public function __construct(PrimeFactors $primeFactors)
    {
        parent::__construct();
        $this->primeFactors = $primeFactors;
    }

    protected function configure()
    {
        $this
            ->setName('prime:factor')
            ->setDescription('Calculate the factors of a prime number')
            ->addArgument('number', InputArgument::REQUIRED, 'What number do we calculate from?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $starttime = microtime(true);
        $number = $input->getArgument('number');
        $output->writeln('<comment>Calculating prime factors for '.$number.'...</comment>');

        $factors = $this->primeFactors->generate($number);
        $time = microtime(true) - $starttime;
        if (count($factors) == 1) {
            $output->writeln('<info>'.$number.' is already a prime</info>');
        } else {
            $output->writeln('<info>Prime factors: ' . implode(',', $factors) . '</info>');
        }
        $output->writeln('Timing: '.number_format($time, 5).' seconds');
    }
}