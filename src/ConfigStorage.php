<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

namespace skeeks\yii2\config;

use yii\base\Component;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class ConfigStorage extends Component implements IConfigStorage
{
    /**
     * @param ConfigBehavior $configBehavior
     * @param bool           $runValidation
     * @param null           $attributeNames
     * @return bool
     */
    public function save(ConfigBehavior $configBehavior, $runValidation = true, $attributeNames = null)
    {
        return true;
    }

    /**
     * @param ConfigBehavior $configBehavior
     * @return bool
     */
    public function exists(ConfigBehavior $configBehavior)
    {
        return (bool)$this->fetch($configBehavior);
    }

    /**
     * @return array
     */
    public function fetch(ConfigBehavior $configBehavior)
    {
        return [];
    }

    /**
     * @return bool
     */
    public function delete(ConfigBehavior $configBehavior)
    {
        return true;
    }
}

