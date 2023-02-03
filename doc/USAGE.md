# Netgen Symfony Tools template usage examples

## Template operators

### `symfony_include`

`symfony_include` template operator enables you to include a Twig template (or any kind of template available to Symfony) from your eZ Publish legacy template.

You need to specify the template name and list of parameters that will be transferred to the included template.

If any of your parameters are instances of `eZContentObject` or `eZContentObjectTreeNode`, they will be converted to instances of `\Ibexa\Contracts\Core\Repository\Values\Content\Content` and `\Ibexa\Contracts\Core\Repository\Values\Content\Location` respectivelly, before being passed to the included template.

Example call:

```smarty
{symfony_include(
    'NetgenTestBundle:Test:test.html.twig',
    hash(
        'theAnswer', 42,
        'homepage', fetch( 'content', 'node', hash( 'node_id', 2 ) )
    )
)}
```

### `symfony_path`

`symfony_path` template operator gets a relative URL for the given route. Parameters are the same as with Twig `path` template function so please refer to [this page][1] for documentation.

This template operator can be used together with `symfony_render` template operator (see below) to refer to the route that you want to render.

Example call:

```smarty
{symfony_path(
    'netgen_test_route',
    hash( 'theAnswer', 42 )
)}
```

### `symfony_url`

`symfony_url` template operator gets an absolute URL for the given route. Parameters are the same as with Twig `url` template function so please refer to [this page][1] for documentation.

This template operator can be used together with `symfony_render` template operator (see below) to refer to the route that you want to render.

Example call:

```smarty
{symfony_url(
    'netgen_test_route',
    hash( 'theAnswer', 42 )
)}
```

### `symfony_controller`

`symfony_controller` template operator is not useful by itself. It is used together with `symfony_render` template operator (see below) to refer to the controller that you want to render. Parameters are the same as with Twig `controller` template function so please refer to [this page][1] for documentation.

If any of your parameters are instances of `eZContentObject` or `eZContentObjectTreeNode`, they will be converted to instances of `\Ibexa\Contracts\Core\Repository\Values\Content\Content` and `\Ibexa\Contracts\Core\Repository\Values\Content\Location` respectivelly, before being passed to the controller.

Example call:

```smarty
{symfony_controller(
    'NetgenTestBundle:Test:test',
    hash(
        'theAnswer', 42,
        'homepage', fetch( 'content', 'node', hash( 'node_id', 2 ) )
    ),
    hash(
        'queryParam1', 'netgen',
        'queryParam2', 'symfony'
    )
)}
```

### `symfony_render`

`symfony_render` template operator is a big one. It allows you to render a Symfony controller directly in eZ Publish legacy template. Parameters are the same as with Twig `render` template function so please refer to [this page][1] for documentation.

Example calls:

```smarty
{symfony_render(
    symfony_controller(
        'NetgenTestBundle:Test:test',
        hash(
            'theAnswer', 42,
            'homepage', fetch( 'content', 'node', hash( 'node_id', 2 ) )
        )
    )
)}
```

```smarty
{symfony_render(
    symfony_path(
        'netgen_test_route',
        hash( 'theAnswer', 42 )
    )
)}
```

```smarty
{symfony_render(
    symfony_url(
        'netgen_test_route',
        hash( 'theAnswer', 42 )
    )
)}
```

### `symfony_render_esi` and `symfony_render_hinclude`

`symfony_render_esi` and `symfony_render_hinclude` template operators generate an ESI tag or Hinclude tag, respectivelly, for the given controller or URL. Parameters are the same as with Twig `render_esi` and `render_hinclude` template functions so please refer to [this page][1] for documentation.

`symfony_render_esi` template operator can be used instead of `symfony_render` operator, because underlying `render_esi` Twig template function falls back to `render` behavior if reverse proxy is not detected by Symfony.

ESI example call:

```smarty
{symfony_render_esi(
    symfony_controller(
        'NetgenTestBundle:Test:test',
        hash(
            'theAnswer', 42,
            'homepage', fetch( 'content', 'node', hash( 'node_id', 2 ) )
        )
    )
)}
```

Hinclude example call:

```smarty
{symfony_render_hinclude(
    symfony_controller(
        'NetgenTestBundle:Test:test',
        hash(
            'theAnswer', 42,
            'homepage', fetch( 'content', 'node', hash( 'node_id', 2 ) )
        )
    )
)}
```

### `symfony_is_granted`

`symfony_is_granted` template operator enables you to use Symfony's `is_granted` Twig function from your legacy template.

Example call:

```smarty
{set $is_admin = symfony_is_granted( 'ROLE_ADMIN' )}
```

[1]: http://symfony.com/doc/current/reference/twig_reference.html
