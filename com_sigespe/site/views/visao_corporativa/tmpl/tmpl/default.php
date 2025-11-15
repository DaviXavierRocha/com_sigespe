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

HTMLHelper::_('bootstrap.modal');
HTMLHelper::_('bootstrap.offcanvas');

$user = Factory::getUser();
$loggedIn = !$user->guest;
?>

<!-- HEADER MILITAR OFICIAL -->
<div class="bg-success text-white py-4 shadow-sm">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="<?php echo JURI::base(); ?>images/brasao-eb.png" alt="Exército Brasileiro" width="60" class="me-3">
                <h2 class="mb-0 fw-bold text-warning">
                    3º BEC - Batalhão de Engenharia de Construção
                </h2>
            </div>
            <div>
                <?php if (!$loggedIn): ?>
                    <button class="btn btn-warning btn-lg fw-bold text-dark border border-dark shadow" 
                            data-bs-toggle="modal" data-bs-target="#loginSigespe">
                        ACESSO RESTRITO
                    </button>
                <?php else: ?>
                    <a href="<?php echo Route::_('index.php?option=com_sigespe&view=gestao_pessoal'); ?>" 
                       class="btn btn-light text-success btn-lg me-3 fw-bold shadow">
                        GESTÃO DE PESSOAL
                    </a>
                    <a href="<?php echo Route::_('index.php?option=com_users&task=user.logout&' . JSession::getFormToken() . '=1'); ?>" 
                       class="btn btn-danger btn-lg fw-bold shadow">
                        SAIR
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <!-- TÍTULO PRINCIPAL -->
    <div class="text-center mb-5">
        <h1 class="display-4 text-success fw-bold">VISÃO CORPORATIVA</h1>
        <p class="lead text-muted">Sistema de Gestão de Pessoal - SIGESPE</p>
        <hr class="border-success border-3 opacity-75 w-25 mx-auto">
    </div>

    <!-- CARDS DE EFETIVO -->
    <div class="row g-4">
        <!-- COMPANHIAS -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-primary shadow-lg h-100 text-center bg-gradient bg-primary bg-opacity-10">
                <div class="card-body p-4">
                    <h5 class="card-title text-primary fw-bold fs-4">COMPANHIAS</h5>
                    <p class="display-3 fw-bold text-primary mb-0"><?php echo $this->companhias; ?></p>
                </div>
            </div>
        </div>

        <!-- SEÇÕES -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-success shadow-lg h-100 text-center bg-gradient bg-success bg-opacity-10">
                <div class="card-body p-4">
                    <h5 class="card-title text-success fw-bold fs-4">SEÇÕES</h5>
                    <p class="display-3 fw-bold text-success mb-0"><?php echo $this->secoes; ?></p>
                </div>
            </div>
        </div>

        <!-- MILITARES -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-warning shadow-lg h-100 text-center bg-gradient bg-warning bg-opacity-10">
                <div class="card-body p-4">
                    <h5 class="card-title text-warning fw-bold fs-4">MILITARES</h5>
                    <p class="display-3 fw-bold text-warning mb-0"><?php echo $this->militares; ?></p>
                </div>
            </div>
        </div>

        <!-- PRONTO PARA SERVIÇO -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-danger shadow-lg h-100 text-center bg-gradient bg-danger bg-opacity-10">
                <div class="card-body p-4">
                    <h5 class="card-title text-danger fw-bold fs-4">PRONTO P/ SERVIÇO</h5>
                    <p class="display-3 fw-bold text-danger mb-0"><?php echo $this->pronto_servico; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE LOGIN MILITAR -->
<div class="modal fade" id="loginSigespe" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-success shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">SIGESPE - ACESSO RESTRITO</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo Route::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="needs-validation" novalidate>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-success">USUÁRIO</label>
                        <input type="text" name="username" class="form-control form-control-lg" 
                               value="cmt3bec" required placeholder="Digite seu usuário">
                        <div class="invalid-feedback">Campo obrigatório.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-success">SENHA</label>
                        <input type="password" name="password" class="form-control form-control-lg" 
                               value="cmt3bec" required placeholder="Digite sua senha">
                        <div class="invalid-feedback">Campo obrigatório.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-lg px-5 fw-bold">ENTRAR</button>
                </div>
                <?php echo HTMLHelper::_('form.token'); ?>
                <input type="hidden" name="return" 
                       value="<?php echo base64_encode(Route::_('index.php?option=com_sigespe&view=visao_corporativa')); ?>">
            </form>
        </div>
    </div>
</div>

<!-- ESTILO MILITAR PERSONALIZADO -->
<style>
    .bg-gradient {
        background: linear-gradient(135deg, rgba(0,128,0,0.05) 0%, rgba(255,215,0,0.05) 100%);
    }
    .card:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important;
    }
    .btn-warning:hover {
        background-color: #ffc107 !important;
        transform: scale(1.05);
        transition: all 0.2s ease;
    }
</style>

<script>
    // Validação Bootstrap
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>