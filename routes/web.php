<?php
use Aura\Router\RouterContainer;

$routerContainer = new RouterContainer();

$map = $routerContainer->getMap();

$map->get('admin', '/admin')->wildcard('card');

$map->get('editor', '/editor')->wildcard('card');

$map->post('save', '/editor')->wildcard('card');

$map->get('browser', '/browser')->wildcard('card');
