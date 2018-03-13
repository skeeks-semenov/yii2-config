<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 11.03.2018
 */

namespace skeeks\yii2\config;

use skeeks\cms\components\Cms;
use skeeks\yii2\form\IHasForm;
use yii\base\Behavior;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\Widget;
use yii\base\WidgetEvent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @property ConfigBehavior $configBehavior
 *
 * Class ConfigStorage
 * @package skeeks\yii2\config
 */
class ConfigStorage extends Component implements IConfigStorage
{
    /**
     * @var ConfigBehavior
     */
    public $_configBehavior;

    public function save($runValidation = true, $attributeNames = null)
    {
        return true;
    }

    /**
     * @return array
     */
    public function fetch()
    {
        return [];
    }

    /**
     * @return bool
     */
    public function delete()
    {
        return true;
    }

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

