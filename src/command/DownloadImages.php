<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class DownloadImages extends \Knp\Command\Command 
{

    protected function configure()
    {
        $this->setName("download:images")
            ->setDescription("Download needed images.")
            ->addArgument(
                "provider",
                InputArgument::REQUIRED,
                "Please provide the provider for which you want the images to be downloaded.")
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
            $guzzleClient = new \GuzzleHttp\Client();
            $providerCred = $app['keys']['apis'][$providerIdent];
            $filesUrl = $providerCred['filesUrl'];

            $options = [
                "login" => $providerCred['user'],
                "password" => $providerCred['pass']
            ];

            //write the file down
            $fs = new Filesystem();
            try {
                $imagesRoot = $app['settings']['imagesDownloadDir'].$providerIdent;
                $imagesData = $this->getSilexApplication()['db']->fetchAll("SELECT * FROM hotel_images");

                foreach($imagesData as $data) {
                    $hotelDir = $imagesRoot."/".$data["hotel_id"];
                    if(!$fs->exists($hotelDir)) {
                        $fs->mkdir($hotelDir);
                        echo "The dir $hotelDir was created.\n";
                    }

                    $filePath = $hotelDir."/".$data["name"];
                    if(!$fs->exists($filePath)) {
                        $res = $guzzleClient->request('GET', $filesUrl, [
                            'auth' => [$providerCred['user'], $providerCred['pass']],
                            'query' => 'file='.$data["id_at_provider"]
                        ]); 
                        $fs->touch($filePath);
                        $fs->dumpFile($filePath, $res->getBody());
                        echo "The file $filePath was written.\n";
                    }
                }

            } catch(IOExceptionInterface $e) {
                $errMsg = "An error occurred while creating your directory at ".$e->getPath()." (".$e->getMessage().")";
                $output->writeln("<error>".$errMsg."</error>");
            }
        }

    }
}
