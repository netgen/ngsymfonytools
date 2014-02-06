# Netgen Symfony Tools template usage examples

## Template operators

### `symfony_include`

`symfony_include` template operator enables you to include a Twig template (or any kind of template available to Symfony) from your eZ Publish legacy template.

You need to specify the template name and list of parameters that will be transferred to the included template.

If any of your parameters are instances of `eZContentObject` or `eZContentObjectTreeNode`, they will be converted to instances of `\eZ\Publish\API\Repository\Values\Content\Content` and `\eZ\Publish\API\Repository\Values\Content\Location` respectivelly, before being passed to the included template.

Example call:

```smarty
{symfony_include(
    'NetgenTestBundle:Test:test.html.twig',
    hash(
        'theAnswer', 42,
        'homepage', fetch( content, node, hash( node_id, 2 ) )
    )
)}
```

### `symfony_path`

`symfony_path` template operator get a relative URL for the given route. Parameters are the same as with Twig `path` template function so please refer to [this page][1] for documentation.

This template operator can be used together with `symfony_render` template operator (see below) to refer to the route that you want to render.

Example call:

```smarty
{symfony_path(
    'netgen_test_route',
    hash( 'theAnswer', 42 )
)}
```

### `symfony_url`

`symfony_url` template operator get an absolute URL for the given route. Parameters are the same as with Twig `url` template function so please refer to [this page][1] for documentation.

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

Example call:

```smarty
{symfony_controller(
    'NetgenTestBundle:Test:test.html.twig',
    hash(
        'theAnswer', 42,
        'homepage', fetch( content, node, hash( node_id, 2 ) )
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
        'NetgenTestBundle:Test:test.html.twig',
        hash(
            'theAnswer', 42,
            'homepage', fetch( content, node, hash( node_id, 2 ) )
        ),
        hash(
            'queryParam1', 'netgen',
            'queryParam2', 'symfony'
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

[1]: http://symfony.com/doc/current/reference/twig_reference.html
