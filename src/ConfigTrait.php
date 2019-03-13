<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

namespace skeeks\yii2\config;

use skeeks\yii2\form\IHasForm;
use yii\base\Model;
use yii\base\Widget;

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

    /**
     * Initializes the object.
     * This method is called at the end of the constructor.
     * The default implementation will trigger an [[EVENT_INIT]] event.
     */
    public function init()
    {
        parent::init();
        $this->trigger(Widget::EVENT_INIT);
    }
}

