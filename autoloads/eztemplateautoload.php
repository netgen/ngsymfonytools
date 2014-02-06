<?php

$eZTemplateOperatorArray = array();

$eZTemplateOperatorArray[] = array(
    'class' => 'NgSymfonyToolsIncludeOperator',
    'operator_names' => array( 'symfony_include' )
);

$eZTemplateOperatorArray[] = array(
    'class' => 'NgSymfonyToolsRenderOperator',
    'operator_names' => array( 'symfony_render' )
);

$eZTemplateOperatorArray[] = array(
    'class' => 'NgSymfonyToolsRenderStrategyOperator',
    'operator_names' => array( 'symfony_render_esi', 'symfony_render_hinclude' )
);

$eZTemplateOperatorArray[] = array(
    'class' => 'NgSymfonyToolsControllerOperator',
    'operator_names' => array( 'symfony_controller' )
);

$eZTemplateOperatorArray[] = array(
    'class' => 'NgSymfonyToolsPathOperator',
    'operator_names' => array( 'symfony_path' )
);

$eZTemplateOperatorArray[] = array(
    'class' => 'NgSymfonyToolsUrlOperator',
    'operator_names' => array( 'symfony_url' )
);
