<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class DownloadPackages extends \Knp\Command\Command 
{

    protected function configure()
    {
        $this->setName("download:packages")
            ->setDescription("Download the packages for a given provider and place the data into a file.")
            ->addArgument(
                "provider",
                InputArgument::REQUIRED,
                "Please provide the provider for which do you want to download the packages")
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $providerIdent = $input->getArgument("provider");
        $providerData = $app['service.provider']->getProviderData($providerIdent);

        if(empty($providerData)) {
            $output->writeln("<error>Invalid provider identificator provided.</error>");
            return;
        } else {

            //maybe a factory will be very good here
            $providerCred = $app['keys']['apis'][$providerIdent];
            $wsdlUrI = $providerCred['url'];
            $options = [
                "login" => $providerCred['user'],
                "password" => $providerCred['pass']
            ];

            $client = new \SoapClient($wsdlUrI, $options);
            $geography = $client->GetPackages();

            //write the file down
            $fs = new Filesystem();
            try {
                $fileName = $app['settings']['packagesDownloadDir'].$providerIdent.".json";
                $fs->touch($fileName);
                $fs->dumpFile($fileName, json_encode($geography));
            } catch(IOExceptionInterface $e) {
                $errMsg = "An error occurred while creating your directory at ".$e->getPath()." (".$e->getMessage().")";
                $output->writeln("<error>".$errMsg."</error>");
            }
        }

    }
}
