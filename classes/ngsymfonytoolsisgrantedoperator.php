<?php

use Symfony\Component\Security\Acl\Voter\FieldVote;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;

class NgSymfonyToolsIsGrantedOperator
{
    /**
     * Returns the list of template operators this class supports
     *
     * @return array
     */
    function operatorList()
    {
        return array( 'symfony_is_granted' );
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
            'symfony_is_granted' => array(
                'role' => array(
                    'required' => true
                ),
                'object' => array(
                    'required' => false,
                    'default' => null
                ),
                'field' => array(
                    'required' => false,
                    'default' => null
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
        $role = $namedParameters['role'];
        $object = isset( $namedParameters['object'] ) ? $namedParameters['object'] : null;
        $field = isset( $namedParameters['field'] ) ? $namedParameters['field'] : null;

        $operatorValue = self::isGranted( $role, $object, $field );
    }

    /**
     * Returns if the current user has access to provided role.
     *
     * @param mixed $role
     * @param mixed $object
     * @param mixed $field
     *
     * @return bool
     */
    public static function isGranted( $role, $object = null, $field = null )
    {
        $serviceContainer = ezpKernel::instance()->getServiceContainer();

        if ( $field !== null && class_exists( 'Symfony\Component\Security\Acl\Voter\FieldVote' ) )
        {
            $object = new FieldVote( $object, $field );
        }

        try
        {
            return $serviceContainer->get( 'security.authorization_checker' )->isGranted( $role, $object );
        }
        catch ( AuthenticationCredentialsNotFoundException $e )
        {
            return false;
        }
    }
}
