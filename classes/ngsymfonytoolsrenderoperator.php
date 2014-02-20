<?php

use Symfony\Component\HttpKernel\Controller\ControllerReference;

class NgSymfonyToolsRenderOperator
{
    /**
     * Returns the list of template operators this class supports
     *
     * @return array
     */
    function operatorList()
    {
        return array( 'symfony_render', 'symfony_render_esi', 'symfony_render_hinclude' );
    }

    /**
     * Indicates if the template operators have named parameters
     *
     * @return bool
     */
    function namedParameterPerOperator()
    {
        return true;
    }

    /**
     * Returns the list of template operator parameters
     *
     * @return array
     */
    function namedParameterList()
    {
        return array(
            'symfony_render' => array(
                'uri' => array(
                    'type' => 'string',
                    'required' => true
                ),
                'options' => array(
                    'type' => 'array',
                    'required' => false,
                    'default' => array()
                )
            ),
            'symfony_render_esi' => array(
                'uri' => array(
                    'type' => 'string',
                    'required' => true
                ),
                'options' => array(
                    'type' => 'array',
                    'required' => false,
                    'default' => array()
                )
            ),
            'symfony_render_hinclude' => array(
                'uri' => array(
                    'type' => 'string',
                    'required' => true
                ),
                'options' => array(
                    'type' => 'array',
                    'required' => false,
                    'default' => array()
                )
            )
        );
    }

    /**
     * Executes the template operator
     *
     * @param eZTemplate $tpl
     * @param string $operatorName
     * @param mixed $operatorParameters
     * @param string $rootNamespace
     * @param string $currentNamespace
     * @param mixed $operatorValue
     * @param array $namedParameters
     * @param mixed $placement
     */
    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters, $placement )
    {
        if ( !$namedParameters['uri'] instanceof ControllerReference &&
             !( is_string( $namedParameters['uri'] ) && !empty( $namedParameters['uri'] ) ) )
        {
            $tpl->error( $operatorName, "$operatorName parameter 'uri' must be a non empty string or a controller reference.", $placement );
            return;
        }

        $uri = $namedParameters['uri'];

        if ( $namedParameters['options'] !== null && !is_array( $namedParameters['options'] ) )
        {
            $tpl->error( $operatorName, "$operatorName parameter 'options' must be a hash array.", $placement );
            return;
        }

        $options = $namedParameters['options'] !== null ? $namedParameters['options'] : array();

        if ( $operatorName === 'symfony_render_esi' )
        {
            $options['strategy'] = 'esi';
        }
        else if ( $operatorName === 'symfony_render_hinclude' )
        {
            $options['strategy'] = 'hinclude';
        }

        $operatorValue = self::renderUri( $uri, $options );
    }

    /**
     * Renders the given URI with Symfony stack
     *
     * @param string|\Symfony\Component\HttpKernel\Controller\ControllerReference $uri
     * @param array $options
     *
     * @return string
     */
    public static function renderUri( $uri, $options = array() )
    {
        $serviceContainer = ezpKernel::instance()->getServiceContainer();
        $fragmentHandler = $serviceContainer->get( 'fragment.handler' );

        $strategy = isset( $options['strategy'] ) ? $options['strategy'] : 'inline';
        unset( $options['strategy'] );

        try
        {
            return $fragmentHandler->render( $uri, $strategy, $options );
        }
        catch ( InvalidArgumentException $e )
        {
            throw new InvalidArgumentException( "The URI {$uri->controller} couldn't be rendered", 0, $e );
        }
    }
}
