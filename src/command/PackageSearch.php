<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class PackageSearch extends \Knp\Command\Command 
{

    protected function configure()
    {
        $this->setName("search:package")
            ->setDescription("Search for a package")
            ->addArgument(
                "provider",
                InputArgument::REQUIRED,
                "Please provide the providerident ")
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $providerIdent = $input->getArgument("provider");
        //$providerData = $app['service.provider']->getProviderData($providerIdent);

        //if(empty($providerData)) {
        //    $output->writeln("<error>Invalid provider identificator provided.</error>");
        //    return;
        //} else {

            //maybe a factory will be very good here
            $providerCred = $app['keys']['apis'][$providerIdent];
            $wsdlUrI = $providerCred['url'];
            $options = [
                "login" => $providerCred['user'],
                "password" => $providerCred['pass'],
                "PackageId" => 52353
            ];

            $client = new \SoapClient($wsdlUrI, $options);
            $data = $client->PackageSearch();

            print_r($data);

        //}

    }
}

