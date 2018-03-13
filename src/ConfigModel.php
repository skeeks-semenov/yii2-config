<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 11.03.2018
 */

namespace skeeks\yii2\config;

use skeeks\yii2\form\IHasForm;
use yii\base\Model;

/**
 * @property ConfigBehavior $configBehavior
 *
 * Class ConfigModel
 * @package skeeks\yii2\config
 */
class ConfigModel extends Model implements IHasForm
{
    /**
     * @see Builder
     * @return array
     */
    public function builderFields()
    {
        return [];
    }

    /**
     * @see Builder
     * @return array
     */
    public function builderModels()
    {
        return [];
    }

    /**
     * @var ConfigBehavior
     */
    public $_configBehavior;

    /**
     * @return ConfigBehavior
     */
    public function getConfigBehavior()
    {
        return $this->_configBehavior;
    }
    /**
     * @return ConfigBehavior
     */
    public function setConfgiBehavior(ConfigBehavior $configBehavior)
    {
        $this->_configBehavior = $configBehavior;
        return $this;
    }
}