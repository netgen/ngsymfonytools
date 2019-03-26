<?php

$eZTemplateOperatorArray = array();

$eZTemplateOperatorArray[] = array(
    'class' => 'NgSymfonyToolsIncludeOperator',
    'operator_names' => array( 'symfony_include' )
);

$eZTemplateOperatorArray[] = array(
    'class' => 'NgSymfonyToolsRenderOperator',
    'operator_names' => array( 'symfony_render', 'symfony_render_esi', 'symfony_render_hinclude' )
);

$eZTemplateOperatorArray[] = array(
    'class' => 'NgSymfonyToolsControllerOperator',
    'operator_names' => array( 'symfony_controller' )
);

$eZTemplateOperatorArray[] = array(
    'class' => 'NgSymfonyToolsPathUrlOperator',
    'operator_names' => array( 'symfony_path', 'symfony_url' )
);

$eZTemplateOperatorArray[] = array(
    'class' => 'NgSymfonyToolsIsGrantedOperator',
    'operator_names' => array( 'symfony_is_granted' )
);
