<?php
use Aura\Router\RouterContainer;

$routerContainer = new RouterContainer();

$map = $routerContainer->getMap();

$map->get('admin', '/admin')->wildcard('card');

$map->get('edit', '/edit')->wildcard('card');

$map->post('save', '/edit')->wildcard('card');

$map->get('view', '/view')->wildcard('card');
