<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class SyncGeography extends \Knp\Command\Command 
{

    protected function configure()
    {
        $this->setName("sync:geography")
            ->setDescription("Syncronizes the geography for a given provider.")
            ->addArgument(
                "provider",
                InputArgument::REQUIRED,
                "Please provide the provider for which do you want to download the geography")
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $service = $app['service.geography'];
        $providerIdent = $input->getArgument("provider");
        $providerData = $app['service.provider']->getProviderData($providerIdent);

        if(empty($providerData)) {
            $output->writeln("<error>Invalid provider identificator provided.</error>");
            return;
        } else {
            //downloaded objects
            $data = json_decode(file_get_contents($app['settings']['geographyDownloadDir'].$providerIdent."/chrGeography.json"));
            $o = $service->translateFromStdObject($data, $providerData['id']);
            $synced = $service->sync($o, $providerData['id']);
            echo "Synced: ",$synced,"\r\n";
            die;
        }

    }
}
