<?php
/**
 * @package     com_sigespe
 * @subpackage  site
 * @author      3º Sgt Davi Rocha
 * @copyright   3º BEC - Exército Brasileiro
 * @license     GPL v3
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

HTMLHelper::_('bootstrap.tab');
HTMLHelper::_('bootstrap.modal');
?>

<!-- HEADER GESTÃO -->
<div class="bg-success text-white py-4 shadow-sm">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="<?php echo JURI::base(); ?>images/brasao-eb.png" alt="EB" width="50" class="me-3">
                <h2 class="mb-0 fw-bold text-warning">GESTÃO DE PESSOAL - SIGESPE</h2>
            </div>
            <a href="<?php echo Route::_('index.php?option=com_sigespe&view=visao_corporativa'); ?>" 
               class="btn btn-light text-success btn-lg fw-bold">
                ← VISÃO CORPORATIVA
            </a>
        </div>
    </div>
</div>

<div class="container-fluid my-5">
    <div class="row">
        <!-- MENU LATERAL MILITAR -->
        <div class="col-md-3">
            <div class="list-group shadow-sm">
                <a href="#tab-companhia" class="list-group-item list-group-item-action active bg-success text-white fw-bold" data-bs-toggle="list">
                    COMPANHIAS
                </a>
                <a href="#tab-secao" class="list-group-item list-group-item-action fw-bold" data-bs-toggle="list">
                    SEÇÕES
                </a>
                <a href="#tab-militar" class="list-group-item list-group-item-action fw-bold" data-bs-toggle="list">
                    MILITARES
                </a>
                <a href="#tab-carteira" class="list-group-item list-group-item-action fw-bold" data-bs-toggle="list">
                    CARTEIRAS
                </a>
                <a href="#tab-cursos" class="list-group-item list-group-item-action fw-bold" data-bs-toggle="list">
                    CURSOS
                </a>
            </div>

            <!-- BOTÃO RELATÓRIO PDF -->
            <div class="mt-4 text-center">
                <button class="btn btn-danger btn-lg w-100 fw-bold shadow" onclick="gerarRelatorioPDF()">
                    GERAR RELATÓRIO PDF
                </button>
            </div>
        </div>

        <!-- CONTEÚDO DAS ABAS -->
        <div class="col-md-9">
            <div class="tab-content">
                <!-- ABA COMPANHIA -->
                <div class="tab-pane fade show active" id="tab-companhia">
                    <h3 class="text-success fw-bold mb-4">Companhias do 3º BEC</h3>
                    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalCompanhia">
                        + ADICIONAR COMPANHIA
                    </button>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-success">
                                <tr>
                                    <th>ID</th>
                                    <th>NOME</th>
                                    <th>SIGLA</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->companhias as $c): ?>
                                <tr>
                                    <td><?php echo $c->id; ?></td>
                                    <td><strong><?php echo htmlspecialchars($c->nome); ?></strong></td>
                                    <td><span class="badge bg-primary"><?php echo htmlspecialchars($c->sigla); ?></span></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="editarCompanhia(<?php echo $c->id; ?>)">Editar</button>
                                        <button class="btn btn-sm btn-danger" onclick="removerCompanhia(<?php echo $c->id; ?>)">Remover</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ABA SEÇÃO -->
                <div class="tab-pane fade" id="tab-secao">
                    <h3 class="text-success fw-bold mb-4">Seções por Companhia</h3>
                    <?php foreach ($this->companhias as $comp): ?>
                        <div class="card mb-3 shadow-sm">
                            <div class="card-header bg-primary text-white fw-bold">
                                <?php echo htmlspecialchars($comp->nome); ?> (<?php echo htmlspecialchars($comp->sigla); ?>)
                            </div>
                            <div class="card-body p-2">
                                <ul class="list-group list-group-flush">
                                    <?php 
                                    $secoesComp = array_filter($this->secoes, function($s) use ($comp) { return $s->companhia_id == $comp->id; });
                                    foreach ($secoesComp as $s): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><strong><?php echo htmlspecialchars($s->nome); ?></strong> <small class="text-muted">(<?php echo htmlspecialchars($s->sigla); ?>)</small></span>
                                        <div>
                                            <button class="btn btn-sm btn-warning">Editar</button>
                                            <button class="btn btn-sm btn-danger">Remover</button>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- ABA MILITAR -->
                <div class="tab-pane fade" id="tab-militar">
                    <h3 class="text-success fw-bold mb-4">Efetivo de Militares</h3>
                    <div class="alert alert-info">
                        <strong>Em desenvolvimento:</strong> Listagem completa com foto, posto, seção, pronto serviço.
                    </div>
                </div>

                <!-- ABA CARTEIRA -->
                <div class="tab-pane fade" id="tab-carteira">
                    <h3 class="text-success fw-bold mb-4">Carteiras Funcionais</h3>
                    <div class="alert alert-info">
                        <strong>Em desenvolvimento:</strong> CNH, CTPS, Título de Eleitor, etc.
                    </div>
                </div>

                <!-- ABA CURSOS -->
                <div class="tab-pane fade" id="tab-cursos">
                    <h3 class="text-success fw-bold mb-4">Cursos Realizados</h3>
                    <div class="alert alert-info">
                        <strong>Em desenvolvimento:</strong> Cursos civis e militares com certificados.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL COMPANHIA -->
<div class="modal fade" id="modalCompanhia">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Adicionar Companhia</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formCompanhia">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nome</label>
                        <input type="text" class="form-control" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sigla</label>
                        <input type="text" class="form-control text-uppercase" name="sigla" maxlength="10" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">SALVAR</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPT MILITAR -->
<script>
function editarCompanhia(id) {
    alert('Editar companhia ID: ' + id);
}

function removerCompanhia(id) {
    if (confirm('Tem certeza que deseja remover esta companhia?')) {
        alert('Companhia ' + id + ' removida!');
        location.reload();
    }
}

function gerarRelatorioPDF() {
    alert('Relatório PDF do 3º BEC em geração...');
    // Futuro: window.open('relatorio.php', '_blank');
}
</script>