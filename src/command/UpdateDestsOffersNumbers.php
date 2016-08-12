<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

use Util\Time as TimeUtils;

class UpdateDestsOffersNumbers extends \Knp\Command\Command 
{
    use \Traits\Command;

    protected function configure()
    {
        $this->setName("sync:destinations-offers-numbers")
            ->setDescription("Update the number of offers for each destinations.")
            ;
    }

    protected function execute($input, $output)
    {
        $app = $this->getSilexApplication();
        $service = $app['service.destination'];

        //$providerIdent = $input->getArgument("provider");
        //$providerData = $this->getProviderData($input);

        $logger = $app["monolog"];
        $logger->notice("Start destinations offers update");

        $service->setExtraParams(['app' => $app]);

        //there are two possibilities here: str_getcsv or fgetcsv
        //for the moment, we will use str_getcsv
        $startTime = TimeUtils::microTimeFloat();
        $output->writeln("<info>".date('Y-m-d H:i:s')." - start destinations update...</info>");

        $synced = $service->updateDestinationsOffers();

        $endTime = TimeUtils::microTimeFloat();
        $timeSpent = number_format(($endTime - $startTime) / 60, 3);

        $message = "The job ended. Time spend:  ".$timeSpent." minutes";
        $output->writeln("<info>".$message."</info>");
        $logger->notice($message);
    }
}
