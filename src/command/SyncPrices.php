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

class SyncPrices extends \Knp\Command\Command 
{
    use \Traits\Command;

    protected function configure()
    {
        $this->setName("sync:prices")
            ->setDescription("Syncronizes the prices for packages for a given provider.")
            ->addArgument(
                "provider",
                InputArgument::REQUIRED,
                "Please provide the provider for which you want the syncronization to be made")
            ;
    }

    protected function execute($input, $output)
    {
        $app = $this->getSilexApplication();
        $service = $app['service.price'];

        $providerIdent = $input->getArgument("provider");
        $providerData = $this->getProviderData($input);

        $logger = $app["monolog"];
        $logger->notice("Start prices syncronization for ".$providerIdent);

        if(empty($providerData)) {
            $output->writeln("<error>Invalid provider identificator provided.</error>");
            return;
        } else {
            $service->setExtraParams(["providerData" => $providerData, 'app' => $app]);

            //there are two possibilities here: str_getcsv or fgetcsv
            //for the moment, we will use str_getcsv
            $pricesArr = file($app['settings']['pricesDownloadDir'].$providerIdent."/prices.csv");

            $startTime = TimeUtils::microTimeFloat();
            $output->writeln("<info>".date('Y-m-d H:i:s')." - start prices syncronization...</info>");

            $synced = $service->sync($pricesArr);

            $endTime = TimeUtils::microTimeFloat();
            $timeSpent = number_format($endTime - $startTime, 3);

            $message = "Prices syncronization ended. Time spend:  ".$timeSpent;
            $output->writeln("<info>".$message."</info>");
            $logger->notice();
        }
    }
}
