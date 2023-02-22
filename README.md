# Backend Redirect

Backend Redirect Bundle is an extension for [Contao CMS](https://contao.org) version 4.

## Installation

Use [Composer](https://getcomposer.org) to add the bundle to your Contao application:

```bash
composer require ameotoko/backend-redirect
```

## Usage

This bundle adds a backend route to your application (`/contao/redirect` by default). You can supply a query string to it, and it will redirect you to a correspondent backend module after adding proper request token and `ref`. If you have to login, you'll be redirected to `/contao/login` first.

## Why?

Sometimes you might want to let your backend users to access a record editing form, using a direct link, like `/contao?do=members&act=edit&id=42`. For instance, your application might be sending notifications to your editors, where they can click on such a link in the email and proceed directly to editing the record.

Prior to version 5.1, Contao's backend firewall will not let you do it directly – it will force your editors to go through a confirmation screen like this:

![](screenshot.png?raw=true)

which is not a good UX for your editors. With this extension, you can give them links like this:

```
https://example.com/contao/redirect?do=user&act=edit&id=1
```

It will redirect to:

```
https://example.com/contao?do=user&act=edit&id=1&rt=a48be7155094538da5fe2.dO1lxYXxmvHGRIblveDcaZfHJMYJpQbWLaMMtb1oO8g.E4QDt-6hwr-pd9Sn8IGROeW2e544_36kcptUx-4QXvodviGcwqvbrv8o9Q
```

_NOTES:_

1. This will only work for idempotent actions that do not directly change or delete database records, such as e.g. `?act=edit`. In other cases, request token will not be added, and Contao's token check will still kick in.
2. Starting from version `5.1`, Contao does not require request token for idempotent actions anymore, so you do not need this bundle (see [contao/contao#5461](https://github.com/contao/contao/pull/5461)).

## Configuration

You can customize the URL path using route prefix:

```yaml
# config/routes.yaml
app_redirect:
    resource: '@AmeotokoBackendRedirectBundle/Resources/config/_definition.yaml'
    prefix: /contao/my-redirect
```

The endpoint will now be `https://example.com/contao/my-redirect`.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
