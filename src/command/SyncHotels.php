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
    use \Traits\Command;

    protected function configure()
    {
        $this->setName("sync:hotel:data")
            ->setDescription("Syncronizes the hotels for a given provider.")
            ->addArgument(
                "provider",
                InputArgument::REQUIRED,
                "Please provide the provider for which you want the syncronization to be made")
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $service = $app['service.hotel'];

        $providerIdent = $input->getArgument("provider");
        $providerData = $this->getProviderData($input);

        $logger = $app["monolog"];

        $logger->notice("Start hotels syncronization for ".$providerIdent);

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
