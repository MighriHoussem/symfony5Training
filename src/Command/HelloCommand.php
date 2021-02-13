<?php
namespace App\Command;
use App\Service\Greeting;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class HelloCommand extends Command
{
    private $greeting;

    public function __construct(Greeting $greeting = null)
    {
        $this->greeting = $greeting;
    }
    protected function configure()
    {
        $this->setName('app:say-hello')
            ->setDescription('say Hello to user')
                ->addArgument('name',InputArgument::REQUIRED);
    }

    protected function execute (InputInterface $input,OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $output->writeln([
            'Hello from the app',
            '******************',
            '']);
        $output->writeln($this->greeting->greet($name));
    }


}