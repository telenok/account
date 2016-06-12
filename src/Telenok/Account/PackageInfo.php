<?php namespace Telenok\Account;

/**
 * @class Telenok.Account.PackageInfo
 * @extends Telenok.Account.Abstraction.Support.PackageInfo
 * Class describe package like key, base class etc
 */
class PackageInfo extends \Telenok\Core\Abstraction\Support\PackageInfo {

	protected $key = 'account';
	protected $baseClass = '\Telenok\Account\\';
}
