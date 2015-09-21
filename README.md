# Laasti/Response

A view response for symfony/http-foundation to use with template engines.

Waiting for concrete PSR-7 implementations before moving from Symfony.

## Installation

```
composer require laasti/response
```

## Usage

The responder offers multiple types of responses:

1. Raw: Uses content as is
2. View: Uses a template engine to render content
3. Json: Uses the viewdata as JSON content
4. Redirect: Redirects
5. Download: Uses the content of a file and force download
6. Stream: Uses a callback to stream content when it is outputted

Currently, the package offers only a PlainPHP template engine. But, others will be added in the future, suggestions and pull requests are welcomed.

```php
$viewdata = new Laasti\Response\Data\ArrayData;
$engine = new Laasti\Response\Engines(['/path/to/templates']);
$responder = new Laasti\Response\Responder($viewdata, $engine);

$responder->setData('title', 'Hello world');
$responder->setData('meta.description', 'Dummy page'); //Accessible in the template using $meta['description']

$response = $responder->view('template_name');

//Output response
$response->send();

```

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D

## History

See CHANGELOG.md for more information.

## Credits

Author: Sonia Marquette (@nebulousGirl)

## License

Released under the MIT License. See LICENSE.txt file.




