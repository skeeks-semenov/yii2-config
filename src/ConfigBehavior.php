<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 11.03.2018
 */

namespace skeeks\yii2\config;

use skeeks\yii2\form\IHasForm;
use yii\base\Behavior;
use yii\base\Component;
use yii\base\Exception;
use yii\base\InvalidConfigException;

/**
 * Class HasConfigBehavior
 * @package skeeks\yii2\config
 */
class ConfigBehavior extends Behavior
{
    /**
     * @var string
     */
    public $namespace;

    /**
     * @var IHasForm
     */
    public $model;

    /**
     * @var ???
     */
    public $storage;

    public function init()
    {
        parent::init();

        if (!$this->owner instanceof Component) {
            throw new InvalidConfigException('The behavior must be connected to the child class ' . Component::class);
        }
    }
}

