<?php

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class NgSymfonyToolsPathUrlOperator
{
    /**
     * Returns the list of template operators this class supports
     *
     * @return array
     */
    function operatorList()
    {
        return array( 'symfony_path', 'symfony_url' );
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
            'symfony_path' => array(
                'name' => array(
                    'type' => 'string',
                    'required' => true
                ),
                'parameters' => array(
                    'type' => 'array',
                    'required' => false,
                    'default' => array()
                ),
                'relative' => array(
                    'type' => 'boolean',
                    'required' => false,
                    'default' => false
                )
            ),
            'symfony_url' => array(
                'name' => array(
                    'type' => 'string',
                    'required' => true
                ),
                'parameters' => array(
                    'type' => 'array',
                    'required' => false,
                    'default' => array()
                ),
                'scheme_relative' => array(
                    'type' => 'boolean',
                    'required' => false,
                    'default' => false
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
        if ( !is_string( $namedParameters['name'] ) || empty( $namedParameters['name'] ) )
        {
            $tpl->error( $operatorName, "$operatorName parameter 'name' must be a non empty string.", $placement );
            return;
        }

        $name = $namedParameters['name'];

        if ( $namedParameters['parameters'] !== null && !is_array( $namedParameters['parameters'] ) )
        {
            $tpl->error( $operatorName, "$operatorName parameter 'parameters' must be a hash array.", $placement );
            return;
        }

        $parameters = $namedParameters['parameters'] !== null ? $namedParameters['parameters'] : array();

        if ( $operatorName === 'symfony_path' )
        {
            $relative = isset( $namedParameters['relative'] ) && $namedParameters['relative'] === true;
            $operatorValue = self::getPath( $name, $parameters, $relative );
        }
        else if ( $operatorName === 'symfony_url' )
        {
            $schemeRelative = isset( $namedParameters['scheme_relative'] ) && $namedParameters['scheme_relative'] === true;
            $operatorValue = self::getUrl( $name, $parameters, $schemeRelative );
        }
    }

    /**
     * Returns the path for provided route and parameters
     *
     * @param string $name
     * @param array $parameters
     * @param bool $relative
     *
     * @return string
     */
    public static function getPath( $name, $parameters = array(), $relative = false )
    {
        $serviceContainer = ezpKernel::instance()->getServiceContainer();

        return $serviceContainer->get('router')->generate(
            $name,
            $parameters,
            $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH
        );
    }

    /**
     * Returns the URL for provided route and parameters
     *
     * @param string $name
     * @param array $parameters
     * @param bool $schemeRelative
     *
     * @return string
     */
    public static function getUrl( $name, $parameters = array(), $schemeRelative = false )
    {
        $serviceContainer = ezpKernel::instance()->getServiceContainer();

        return $serviceContainer->get('router')->generate(
            $name,
            $parameters,
            $schemeRelative ? UrlGeneratorInterface::NETWORK_PATH : UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
}
