<?php namespace Telenok\Account\Setting\SocialNetwork;

/**
 * @class Telenok.Account.Setting.SocialNetwork.Controller
 * Controller social network setting.
 * 
 * @extends Telenok.Core.Abstraction.Setting.Controller
 */
class Controller extends \App\Vendor\Telenok\Core\Abstraction\Setting\Controller {

    /**
     * @protected
     * @property {String} $key
     * Controller's key.
     * @member Telenok.Account.Setting.SocialNetwork.Controller
     */
    protected $key = 'telenok.social.network';
    
    /**
     * @protected
     * @property {Array} $defaultValue
     * Default values for current settings.
     * @member Telenok.Account.Setting.SocialNetwork.Controller
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
