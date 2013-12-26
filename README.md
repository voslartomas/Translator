Translator
--

This is wrapper for various translator APIs.

Implemented services
--

- Yandex

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
$translation = $service->translate('Hi, how are you?', 'cs', 'en');
```

LICENSE
--

See LICENSE file.
