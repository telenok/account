<?php

namespace Telenok\Account\Factory;

use SocialiteProviders\Manager\Exception\MissingConfigException;
use \Telenok\Account\Contract\ConfigFactory;

class Config implements ConfigFactory
{
    /**
     * @var bool
     */
    public static $spoofedConfig = false;

    public function config($name, $additionalProviderConfig = [])
    {
        $config = $this->getConfig($name, $additionalProviderConfig);

        return new \SocialiteProviders\Manager\Config($config['client_id'], $config['client_secret'], $config['redirect'], $additionalProviderConfig);
    }

    /**
     * @param string $providerClass
     * @param string $providerName
     *
     * @throws MissingConfigException
     *
     * @return array
     */
    protected function getConfig($providerName, $additionalProviderConfig = [])
    {
        $config = null;
        $exceptionMessages = [];

        try
        {
            $config = $this->configRetriever->fromEnv($providerName, $additionalProviderConfig);

            // We will use the $spoofedConfig variable for now as a way to find out if there was no
            // configuration in the .env file which means we should not return anything and jump
            // to the service config check to check if something can be found there.
            if (!static::$spoofedConfig)
            {
                return $config;
            }
        }
        catch (MissingConfigException $e)
        {
            $exceptionMessages[] = $e->getMessage();
        }

        $config = null;

        try
        {
            $config = $this->configRetriever->fromServices($providerName, $additionalProviderConfig);

            // Here we don't need to check for the $spoofedConfig variable because this will be
            // the end of checking for config and should contain either the proper data or an
            // array containing spoofed values.
            return $config;
        }
        catch (MissingConfigException $e)
        {
            $exceptionMessages[] = $e->getMessage();
        }

        throw new MissingConfigException(implode(PHP_EOL, $exceptionMessages));
    }
}
