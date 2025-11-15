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
use Joomla\CMS\Language\Text;

class SigespeViewVisao_Corporativa extends HtmlView
{
    protected $companhias;
    protected $secoes;
    protected $militares;
    protected $pronto_servico;

    public function display($tpl = null)
    {
        $db = Factory::getDbo();

        // Contagem das Companhias
        $query = $db->getQuery(true)
            ->select('COUNT(*)')
            ->from($db->quoteName('#__sigespe_companhia'))
            ->where($db->quoteName('estado') . ' = 1');
        $db->setQuery($query);
        $this->companhias = (int) $db->loadResult();

        // Contagem das Seções
        $query = $db->getQuery(true)
            ->select('COUNT(*)')
            ->from($db->quoteName('#__sigespe_secao'))
            ->where($db->quoteName('estado') . ' = 1');
        $db->setQuery($query);
        $this->secoes = (int) $db->loadResult();

        // Contagem dos Militares
        $query = $db->getQuery(true)
            ->select('COUNT(*)')
            ->from($db->quoteName('#__sigespe_militar'))
            ->where($db->quoteName('estado') . ' = 1');
        $db->setQuery($query);
        $this->militares = (int) $db->loadResult();

        // Contagem Pronto para Serviço
        $query = $db->getQuery(true)
            ->select('COUNT(*)')
            ->from($db->quoteName('#__sigespe_militar'))
            ->where($db->quoteName('pronto_servico') . ' = 1')
            ->where($db->quoteName('estado') . ' = 1');
        $db->setQuery($query);
        $this->pronto_servico = (int) $db->loadResult();

        // Carrega o template
        parent::display($tpl);
    }
}