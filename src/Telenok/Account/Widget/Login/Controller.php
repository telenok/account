<?php

namespace Telenok\Account\Login;


class Controller extends \App\Telenok\Core\Interfaces\Widget\Controller {

    /**
     * @protected
     * @property {String} $key
     * Key of widget.
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected $key = 'login';

    /**
     * @protected
     * @property {String} $parent
     * Parent's widget key.
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected $parent = 'account';

    /**
     * @protected
     * @property {String} $defaultFrontendView
     * Name of view for fronend if user dont want to create own view.
     * @member Telenok.Core.Widget.Menu.Controller
     */
    protected $defaultFrontendView = "account::widget.login.widget-frontend";

    /**
     * @method getNotCachedContent
     * Return not cached content of widget.
     * @return {String}
     * @member Telenok.Account.Widget.Html.Controller
     */
    public function getNotCachedContent()
    {
        if ($t = $this->getFileTemplatePath())
        {
            return file_get_contents($t);
        }
    }
}
