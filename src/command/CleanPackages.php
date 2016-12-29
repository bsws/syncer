<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class CleanPackages extends \Knp\Command\Command 
{
    use \Traits\Command;

    protected function configure()
    {
        $this->setName("clean:packages")
            ->setDescription("Clean the package related tables. Use this carefully")
            ->addOption(
               'clear-prices',
               null,
               InputOption::VALUE_NONE,
               'If set, the prices table will be cleared too.'
            )
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $db = $app['db'];

        $logger = $app["monolog"];

        $logger->info("Start table cleaning.");
        $output->writeln("<info>Start table cleaning...</info>");

        $tables = [
            \Metadata\Package::$table, 
            \Metadata\PackageDepartureDate::$table, 
            \Metadata\DepartureDate::$table, 
            \Metadata\PackageDeparturePoint::$table, 
            \Metadata\PriceSet::$table];

        if ($input->getOption('clear-prices')) {
            $tables[] = \Metadata\Price::$table;
            $tables[] = \Metadata\PriceSet::$table;
        }

        foreach($tables as $table) {
            $q = "TRUNCATE TABLE $table";

            try {
                $db->executeQuery($q);
                $output->writeln("<comment>The table $table was cleard.</comment>");
            } catch(\Exception $Ex) {
                $output->writeln("<error>".$Ex->getMessage()."</error>");
            }
        }

        $output->writeln("<info>The cleaning job was finished.</info>");
    }
}
