<?php

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class NgSymfonyToolsUrlOperator
{
    /**
     * Returns the list of template operators this class supports
     *
     * @return array
     */
    function operatorList()
    {
        return array( 'symfony_url' );
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
        if ( !is_string( $namedParameters['name'] ) && empty( $namedParameters['name'] ) )
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

        $schemeRelative = false;
        if ( isset( $namedParameters['scheme_relative'] ) && $namedParameters['scheme_relative'] === true )
        {
            $schemeRelative = true;
        }

        $operatorValue = self::getUrl( $name, $parameters, $schemeRelative );
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
