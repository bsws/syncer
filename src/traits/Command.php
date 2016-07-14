<?php
namespace Traits;

trait Command
{
    public function getProviderData($input)
    {
        $providerIdent = $input->getArgument("provider");
        $providerData = $this->getSilexApplication()['service.provider']->getProviderData($providerIdent);

        return $providerData;
    }
}
