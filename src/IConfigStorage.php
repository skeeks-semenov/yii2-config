<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

namespace skeeks\yii2\config;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
interface IConfigStorage
{
    /**
     * @param ConfigBehavior $configBehavior
     * @param bool           $runValidation
     * @param null           $attributeNames
     * @return bool
     */
    public function save(ConfigBehavior $configBehavior, $runValidation = true, $attributeNames = null);

    /**
     * @param ConfigBehavior $configBehavior
     * @return array
     */
    public function fetch(ConfigBehavior $configBehavior);

    /**
     * @param ConfigBehavior $configBehavior
     * @return bool
     */
    public function exists(ConfigBehavior $configBehavior);

    /**
     * @return bool
     */
    public function delete(ConfigBehavior $configBehavior);
}

