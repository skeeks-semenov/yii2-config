<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

namespace skeeks\yii2\config;

use skeeks\yii2\form\IHasForm;
use yii\base\Model;

/**
 * @see ConfigBehavior
 *
 * @property Model|IHasForm $configModel
 * @property ConfigStorage  $configStorage
 * @property ConfigBehavior $configBehavior
 * @property array          $callAttributes
 * @property string         $configClassName
 * @property string         $configKey
 *
 * @method $this configRefresh()
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 */
trait ConfigTrait
{

}

