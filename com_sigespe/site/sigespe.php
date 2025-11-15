<?php
// Ficheiro: site/sigespe.php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;

/**
 * Ponto de entrada (Entry Point) do Frontend.
 * Este ficheiro "acorda" o Joomla e diz-lhe para
 * carregar a view (ex: visao_corporativa)
 */

// Carrega o controlador base do Joomla
$controller = BaseController::getInstance('Sigespe');

// Executa a tarefa (ex: 'display')
$controller->execute(Factory::getApplication()->input->get('task'));

// Redireciona se necessário
$controller->redirect();