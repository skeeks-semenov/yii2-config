Yii2 config area for SkeekS CMS
===================================

Links
------
* [Web site](https://cms.skeeks.com)
* [Author](https://skeeks.com)

```php


namespace skeeks\cms\widgets;

use skeeks\yii2\config\ConfigBehavior;
use skeeks\yii2\config\ConfigTrait;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * Class GridView
 * @package skeeks\cms
 */
class TestWidget extends Widget
{
    use ConfigTrait;

    public $test = '22';

    public $config = [];

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [

            ConfigBehavior::class => ArrayHelper::merge([
                'class' => ConfigBehavior::class,
                'configModel' => [
                    'fields' => [
                        'test'
                    ],
                    'attributeDefines' => [
                        'test',
                    ],
                    'attributeLabels' => [
                        'test' => '111',
                    ],
                    'attributeHints' => [
                        'test' => '111',
                    ],
                    'rules' => [
                        ['test', 'string']
                    ]
                ]
            ], (array) $this->config),

        ]);
    }

    public function run()
    {
        return $this->test;
    }
}

```
___

> [![skeeks!](https://skeeks.com/img/logo/logo-no-title-80px.png)](https://skeeks.com)  
<i>SkeekS CMS (Yii2) — quickly, easily and effectively!</i>  
[skeeks.com](https://skeeks.com) | [cms.skeeks.com](https://cms.skeeks.com)



