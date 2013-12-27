Translator
--

This is wrapper for various translator APIs.

Implemented translation services
--

- Yandex
- Google - not tested
- Bing - not tested

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
