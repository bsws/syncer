<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class HotelsSlugify extends \Knp\Command\Command 
{
    use \Traits\Command;

    protected function configure()
    {
        $this->setName("hotel:slugify")
            ->setDescription("Slugifies the hotels.")
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $service = $app['service.hotel'];

        $logger = $app["monolog"];

        $logger->notice("Start hotels slugification.");

        $service->setExtraParams(['app' => $app]);
        $service->slugifyHotels();
        echo "\nThe hotels were slugified";
    }
}
