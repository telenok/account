<?php namespace Telenok\Account\Config\SocialNetwork;

/**
 * @class Telenok.Account.Config.SocialNetwork.Controller
 * Controller social network config.
 * 
 * @extends Telenok.Core.Abstraction.Config.Controller
 */
class Controller extends \App\Vendor\Telenok\Core\Abstraction\Config\Controller {

    /**
     * @protected
     * @property {String} $key
     * Controller's key.
     * @member Telenok.Account.Config.SocialNetwork.Controller
     */
    protected $key = 'telenok.social.network';
    
    /**
     * @protected
     * @property {Array} $defaultValue
     * Default values for current config.
     * @member Telenok.Account.Config.SocialNetwork.Controller
     */
    protected $defaultValue = [
        'services.github.client_id' => "",
        'services.github.client_secret' => "",
        'services.github.redirect' => "",
        'services.github.enabled' => 0,

        'services.facebook.client_id' => "",
        'services.facebook.client_secret' => "",
        'services.facebook.enabled' => 0,

        'services.google.client_id' => "",
        'services.google.client_secret' => "",
        'services.google.enabled' => 0,

        'services.linkedin.client_id' => "",
        'services.linkedin.client_secret' => "",
        'services.linkedin.enabled' => 0,

        'services.twitter.client_id' => "",
        'services.twitter.client_secret' => "",
        'services.twitter.enabled' => 0,

        'services.bitbucket.client_id' => "",
        'services.bitbucket.client_secret' => "",
        'services.bitbucket.enabled' => 0,
    ];
}
