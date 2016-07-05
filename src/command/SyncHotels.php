<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class SyncHotels extends \Knp\Command\Command 
{

    protected function configure()
    {
        $this->setName("sync:hotels")
            ->setDescription("Syncronizes the hotels for a given provider.")
            ->addArgument(
                "provider",
                InputArgument::REQUIRED,
                "Please provide the provider for which do you want the syncronization to be made")
            ;
    }

    protected function execute($input, $output)
    {
        $app = $this->getSilexApplication();
        $service = $app['service.hotel'];
        $providerIdent = $input->getArgument("provider");
        $providerData = $app['service.provider']->getProviderData($providerIdent);
        $logger = $app["monolog"];

        $logger->notice("Start sync hotels for ".$providerIdent);

        if(empty($providerData)) {
            $output->writeln("<error>Invalid provider identificator provided.</error>");
            return;
        } else {
            $service->setExtraParams(["providerData" => $providerData, 'app' => $app]);
            $hotelsArr = json_decode(file_get_contents($app['settings']['hotelsDownloadDir'].$providerIdent."/hotels.json"));
            $o = $service->translateFromStdObjects($hotelsArr, $providerData['id'], $providerIdent);
            $synced = $service->sync($o, $providerData['id'], $providerIdent);
            echo "\r\nSynced: ",$synced,"\r\n";
            die;
        }

    }
}
