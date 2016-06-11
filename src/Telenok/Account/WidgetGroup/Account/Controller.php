<?php namespace Telenok\Account\WidgetGroup\Account;

/**
 * @class Telenok.Account.WidgetGroup.Account.Controller
 * Standart widget's group.
 * @extends Telenok.Core.Abstraction.Widget.Group.Controller
 */
class Controller extends \Telenok\Core\Abstraction\Widget\Group\Controller {

    /**
     * @protected
     * @property {String} $key
     * Key for widget group.
     * @member Telenok.Account.WidgetGroup.Account.Controller
     */
    protected $key = 'account';
    
    /**
     * @protected
     * @property {String} $icon
     * Icon for widget group.
     * @member Telenok.Account.WidgetGroup.Account.Controller
     */
    protected $icon = 'fa fa-signal'; 
}
