Translator
--

This is wrapper for various translate API's.

Installation
--

Add this line into your composer file.

```
require: "webcook/translator": "0.*@dev"
```


Implemented translate services
--

- Yandex
- Google - not tested
- Bing

Usage
--

```
$factory = new Webcook\Translator\ServiceFactory();
$service = $factory->build(
		Webcook\Translator\ServiceFactory::YANDEX,
		array(
			'key' => 'YOUR API KEY'
		)
	);

// returns list of available languages
$languages = $service->getLanguages();

// translate text
$translation = $service->translate('Hi, how are you?', 'en', 'cs');
```

Or you can use multiple settings in service factory.

```
$serviceFactory = new Webcook\Translator\ServiceFactory();

$serviceFactory->setSettings(array(
		\Webcook\Translator\ServiceFactory::YANDEX => array(
		    'key' => 'Yandex API key'
		),
		\Webcook\Translator\ServiceFactory::GOOGLE => array(
		    'key' => 'Google API key'
		),
		\Webcook\Translator\ServiceFactory::BING => array(
		    'clientId' => 'Bing client id',
		    'clientSecret' => 'Bing client secret'
		)
	    ));

$serviceYandex = $this->serviceFactory->build(\Webcook\Translator\ServiceFactory::YANDEX);
$serviceGoogle = $this->serviceFactory->build(\Webcook\Translator\ServiceFactory::GOOGLE);
$serviceBing = $this->serviceFactory->build(\Webcook\Translator\ServiceFactory::BING);
            
```

LICENSE
--

See LICENSE file.
