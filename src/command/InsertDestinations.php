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

class InsertDestinations extends \Knp\Command\Command 
{
    use \Traits\Command;

    protected function configure()
    {
        $this->setName("insert:destinations")
            ->setDescription("Inserts the destinations for a given provider.")
            ->addArgument(
                "provider",
                InputArgument::REQUIRED,
                "Please provide the provider for which you want the insert to be made")
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $service = $app['service.destination'];

        $providerIdent = $input->getArgument("provider");
        $providerData = $this->getProviderData($input);

        $logger = $app["monolog"];
        $logger->notice("Start destinations insert job for ".$providerIdent);

        if(empty($providerData)) {
            $output->writeln("<error>Invalid provider identificator provided.</error>");
            return;
        } else {
            $service->setExtraParams(["providerData" => $providerData, 'app' => $app]);

            //there are two possibilities here: str_getcsv or fgetcsv
            //for the moment, we will use str_getcsv
            $destinationsArr = json_decode(file_get_contents($app['settings']['destinationsDownloadDir'].$providerIdent."/destinations.json"));

            $startTime = TimeUtils::microTimeFloat();
            $output->writeln("<info>".date('Y-m-d H:i:s')." - start destinations insert</info>");

            $insertDestinations = $service->sync($destinationsArr);

            $endTime = TimeUtils::microTimeFloat();
            $timeSpent = number_format(($endTime - $startTime) / 60, 3);

            $message = "Destinations insert ended ($insertDestinations inserted). Time spend:  ".$timeSpent." minutes";
            $output->writeln("<info>".$message."</info>");
            $logger->notice($message);
        }
    }
}
