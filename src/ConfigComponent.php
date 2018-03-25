<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

namespace skeeks\yii2\config;

use yii\base\Component;
use yii\helpers\ArrayHelper;

/**
 * An example of a component that contains the behavior of the settings
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 */
abstract class ConfigComponent extends Component
{
    use ConfigTrait;

    /**
     * @var array
     */
    public $configBehaviorData = [];

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            ConfigBehavior::class => ArrayHelper::merge([
                'class'       => ConfigBehavior::class,
                'configModel' => [
                    'fields'           => [
                        'caption',
                    ],
                    'attributeDefines' => [
                        'caption',
                    ],
                    'attributeLabels'  => [
                        'caption' => 'Заголовок таблицы',
                    ],
                    'rules'            => [
                        ['caption', 'string'],
                    ],
                ],
            ], (array)$this->configBehaviorData),
        ]);
    }
}

