<?php
/**
 * @package     com_sigespe
 * @subpackage  site
 * @author      3º Sgt Davi Rocha
 * @copyright   3º BEC - Exército Brasileiro
 * @license     GPL v3
 */

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

class SigespeViewGestao_Pessoal extends HtmlView
{
    protected $user;
    protected $isAdmin;

    public function display($tpl = null)
    {
        $this->user = Factory::getUser();
        $this->isAdmin = $this->user->authorise('core.admin', 'com_sigespe') || $this->user->authorise('core.manage', 'com_sigespe');

        if (!$this->isAdmin) {
            throw new \Exception('Acesso negado. Você não tem permissão para acessar a Gestão de Pessoal.', 403);
        }

        // Carrega os dados para os menus
        $this->loadData();

        parent::display($tpl);
    }

    protected function loadData()
    {
        $db = Factory::getDbo();

        // Companhias
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__sigespe_companhia'))
            ->where($db->quoteName('estado') . ' = 1')
            ->order('ordenacao ASC, nome ASC');
        $db->setQuery($query);
        $this->companhias = $db->loadObjectList();

        // Seções
        $query = $db->getQuery(true)
            ->select('s.*, c.nome AS companhia_nome')
            ->from($db->quoteName('#__sigespe_secao') . ' AS s')
            ->join('LEFT', $db->quoteName('#__sigespe_companhia') . ' AS c ON c.id = s.companhia_id')
            ->where('s.estado = 1')
            ->order('c.ordenacao, s.ordenacao');
        $db->setQuery($query);
        $this->secoes = $db->loadObjectList();
    }
}