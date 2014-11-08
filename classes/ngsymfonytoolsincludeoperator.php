<?php

class NgSymfonyToolsIncludeOperator
{
    /**
     * Returns the list of template operators this class supports
     *
     * @return array
     */
    function operatorList()
    {
        return array( 'symfony_include' );
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
            'symfony_include' => array(
                'name' => array(
                    'type' => 'string',
                    'required' => true
                ),
                'parameters' => array(
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
        if ( !is_string( $namedParameters['name'] ) || empty( $namedParameters['name'] ) )
        {
            $tpl->error( $operatorName, "$operatorName parameter 'name' must be a non empty string.", $placement );
            return;
        }

        $templateName = $namedParameters['name'];

        if ( $namedParameters['parameters'] !== null && !is_array( $namedParameters['parameters'] ) )
        {
            $tpl->error( $operatorName, "$operatorName parameter 'parameters' must be a hash array.", $placement );
            return;
        }

        $templateParameters = $namedParameters['parameters'] !== null ? $namedParameters['parameters'] : array();

        $apiContentConverter = NgSymfonyToolsApiContentConverter::instance();
        foreach ( $templateParameters as $parameterName => $parameterValue )
        {
            $templateParameters[$parameterName] = $apiContentConverter->convert( $parameterValue );
        }

        $serviceContainer = ezpKernel::instance()->getServiceContainer();
        $templatingEngine = $serviceContainer->get( 'templating' );
        $operatorValue = $templatingEngine->render( $templateName, $templateParameters );
    }
}
