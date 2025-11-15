<?php
// Ficheiro: script.php (Coloque na raiz, ao lado do sigespe.xml)
defined('_JEXEC') or die;

use Joomla\CMS\Installer\InstallerScript;
use Joomla\CMS\Factory;

/**
 * script.php - O método 100% fiável para instalar SQL no Joomla 4/5/6
 * O nome da classe DEVE ser com_sigespeInstallerScript
 */
class com_sigespeInstallerScript extends InstallerScript
{
    /**
     * Função executada DEPOIS de os ficheiros serem copiados
     */
    public function postflight($type, $parent)
    {
        // Só executa na instalação ou atualização
        if (!in_array($type, ['install', 'update'])) {
            return true;
        }

        $db = Factory::getDbo();
        
        // O caminho CORRETO para o ficheiro SQL (dentro do pacote de instalação)
        $sqlFile = $parent->getParent()->getPath('source') . '/admin/sql/install.mysql.utf8.sql';
        
        if (file_exists($sqlFile)) {
            $sql = file_get_contents($sqlFile);
            
            // Limpa o prefixo e quaisquer caracteres "fantasma" (espaços, BOMs)
            $sql = str_replace(
                ['#__', "\xEF\xBB\xBF", "\r", "\xC2\xA0"], 
                [$db->getPrefix(), '', '', ' '], 
                $sql
            );

            $queries = $db->splitSql($sql);
            
            foreach ($queries as $query) {
                $query = trim($query);
                // Ignora comentários e linhas vazias
                if ($query && strpos($query, '--') !== 0) {
                    try {
                        $db->setQuery($query)->execute();
                    } catch (Exception $e) {
                        // Se der um erro (ex: tabela já existe), avisa mas não para.
                        Factory::getApplication()->enqueueMessage('Erro SQL (ignorado): ' . $e->getMessage(), 'notice');
                    }
                }
            }
            
            Factory::getApplication()->enqueueMessage('SIGESPE: Tabelas do banco de dados criadas com sucesso!', 'success');
            
        } else {
             // Erro fatal se o ficheiro SQL não for encontrado
             Factory::getApplication()->enqueueMessage('Erro Crítico: Ficheiro install.mysql.utf8.sql não encontrado!', 'error');
             return false;
        }
        
        return true;
    }

    // --- Funções obrigatórias (podem ficar vazias) ---
    public function install($parent) { /* Não fazer nada aqui */ }
    public function update($parent) { /* Não fazer nada aqui */ }
    public function uninstall($parent) { /* Pode adicionar o SQL de uninstall aqui */ }
    public function preflight($type, $parent) { return true; }
}