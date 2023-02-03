<?php

use Ibexa\Contracts\Core\Repository\Repository;

class NgSymfonyToolsApiContentConverter
{
    /**
     * @var NgSymfonyToolsApiContentConverter
     */
    private static $instance;

    /**
     * @var \Ibexa\Contracts\Core\Repository\Repository
     */
    private $repository;

    /**
     * Instantiates the class object
     *
     * @return NgSymfonyToolsApiContentConverter
     */
    public static function instance()
    {
        if ( self::$instance === null )
        {
            $serviceContainer = ezpKernel::instance()->getServiceContainer();
            self::$instance = new self( $serviceContainer->get( 'ibexa.api.repository' ) );
        }

        return self::$instance;
    }

    /**
     * Constructor
     *
     * @private
     *
     * @param \Ibexa\Contracts\Core\Repository\Repository $repository
     */
    private function __construct( Repository $repository )
    {
        $this->repository = $repository;
    }

    /**
     * Disallows cloning
     */
    private function __clone()
    {
    }

    /**
     * Converts eZ Publish legacy objects and nodes to content and locations
     *
     * @param mixed $object
     *
     * @return mixed
     */
    public function convert( $object )
    {
        if ( $object instanceof eZContentObject )
        {
            return $this->repository->getContentService()->loadContent( $object->attribute( 'id' ) );
        }
        else if ( $object instanceof eZContentObjectTreeNode )
        {
            return $this->repository->getLocationService()->loadLocation( $object->attribute( 'node_id' ) );
        }

        return $object;
    }
}
