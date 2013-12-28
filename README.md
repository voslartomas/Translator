Translator
--

This is wrapper for various translate API's.

Instalation
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

LICENSE
--

See LICENSE file.
