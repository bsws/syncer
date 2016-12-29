<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class SyncPackages extends \Knp\Command\Command 
{
    use \Traits\Command;

    protected function configure()
    {
        $this->setName("sync:packages")
            ->setDescription("Syncronizes the packages for a given provider.")
            ->addArgument(
                "provider",
                InputArgument::REQUIRED,
                "Please provide the provider for which you want the syncronization to be made")
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $service = $app['service.package'];

        $providerIdent = $input->getArgument("provider");
        $providerData = $this->getProviderData($input);

        $logger = $app["monolog"];

        $logger->notice("Start packages syncronization for ".$providerIdent);

        if(empty($providerData)) {
            $output->writeln("<error>Invalid provider identificator provided.</error>");
            return;
        } else {
            $service->setExtraParams(["providerData" => $providerData]);
            $packagesArr = json_decode(file_get_contents($app['settings']['packagesDownloadDir'].$providerIdent."/packages.json"));

            $syncData = $service->sync($packagesArr);
            echo "\r\nThe packages sync job has been ended.\r\n";
            die;
        }

    }
}
