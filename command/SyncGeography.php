<?php
namespace Command;

class SyncGeography extends \Knp\Command\Command 
{

    protected function configure()
    {
        $this->setName("sync:geography")
            ->setDescription("Syncronizes the geography for a given provider.");
    }

    protected function execute($input, $output)
    {
        $app = $this->getSilexApplication();
        print_r($app['keys']);
        $output->writeln("It workds, dude! :D");
    }
}
