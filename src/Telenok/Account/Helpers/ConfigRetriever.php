<?php

namespace Telenok\Account\Helpers;

use SocialiteProviders\Manager\Exception\MissingConfigException;
use SocialiteProviders\Manager\SocialiteWasCalled;

class ConfigRetriever extends \SocialiteProviders\Manager\Helpers\ConfigRetriever
{
    protected $configRetriever = null;

    public function __construct(\SocialiteProviders\Manager\Helpers\ConfigRetriever $configRetriever)
    {
        $this->configRetriever = $configRetriever;
    }

    /**
     * @param string $key
     *
     * @throws MissingConfigException
     *
     * @return string
     */
    protected function getFromEnv($key)
    {
        $host = app('request')->getHost();

        $providerKey = "{$host}_{$this->providerIdentifier}_{$key}";
        $item = env($providerKey);

        // ADDITIONAL value is empty
        if (empty($item) && $this->isAdditionalConfig($key))
        {
            return parent::getFromEnv($key);
        }

        // REQUIRED value is empty
        if (empty($item))
        {
            // If we are running in console we should spoof values to make Socialite happy...
            if (app()->runningInConsole())
            {
                $item = $providerKey;

                SocialiteWasCalled::$spoofedConfig = true;
            }
            else
            {
                return parent::getFromEnv($key);
            }
        }

        return $item;
    }

    /**
     * @param string $providerName
     *
     * @throws MissingConfigException
     *
     * @return array
     */
    protected function getConfigFromServicesArray($providerName)
    {
        $host = app('request')->getHost();

        /** @var array $configArray */
        $configArray = config("services.{$host}.{$providerName}");

        if (empty($configArray))
        {
            // If we are running in console we should spoof values to make Socialite happy...
            if (app()->runningInConsole() && ($key = $this->getFromEnv('KEY')))
            {
                $configArray = [
                    'client_id' => $key, 'client_secret' => $this->getFromEnv('SECRET'), 'redirect' => $this->getFromEnv('REDIRECT_URI'),
                ];

                SocialiteWasCalled::$spoofedConfig = true;
            }
            else
            {
                return parent::getConfigFromServicesArray($providerName);
            }
        }

        $this->servicesArray = $configArray;

        return $this->servicesArray;
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->configRetriever, $name))
        {
            return call_user_func_array(array($this->configRetriever, $name), $arguments);
        }
    }
}
