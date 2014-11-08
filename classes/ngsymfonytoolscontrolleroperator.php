<?php

use Symfony\Component\HttpKernel\Controller\ControllerReference;

class NgSymfonyToolsControllerOperator
{
    /**
     * Returns the list of template operators this class supports
     *
     * @return array
     */
    function operatorList()
    {
        return array( 'symfony_controller' );
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
            'symfony_controller' => array(
                'controller' => array(
                    'type' => 'string',
                    'required' => true
                ),
                'attributes' => array(
                    'type' => 'array',
                    'required' => false,
                    'default' => array()
                ),
                'query' => array(
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
        if ( !is_string( $namedParameters['controller'] ) || empty( $namedParameters['controller'] ) )
        {
            $tpl->error( $operatorName, "$operatorName parameter 'controller' must be a non empty string.", $placement );
            return;
        }

        $controller = $namedParameters['controller'];

        if ( $namedParameters['attributes'] !== null && !is_array( $namedParameters['attributes'] ) )
        {
            $tpl->error( $operatorName, "$operatorName parameter 'attributes' must be a hash array.", $placement );
            return;
        }

        $attributes = $namedParameters['attributes'] !== null ? $namedParameters['attributes'] : array();

        if ( $namedParameters['query'] !== null && !is_array( $namedParameters['query'] ) )
        {
            $tpl->error( $operatorName, "$operatorName parameter 'query' must be a hash array.", $placement );
            return;
        }

        $query = $namedParameters['query'] !== null ? $namedParameters['query'] : array();

        $apiContentConverter = NgSymfonyToolsApiContentConverter::instance();
        foreach ( $attributes as $attributeName => $attributeValue )
        {
            $attributes[$attributeName] = $apiContentConverter->convert( $attributeValue );
        }

        $operatorValue = self::getController( $controller, $attributes, $query );
    }

    /**
     * Returns the controller reference for the specified controller name
     *
     * @param string $controller
     * @param array $attributes
     * @param array $query
     *
     * @return \Symfony\Component\HttpKernel\Controller\ControllerReference
     */
    public static function getController( $controller, $attributes = array(), $query = array() )
    {
        return new ControllerReference( $controller, $attributes, $query );
    }
}
