<?php
/**
 * CodeIgniter Boleto
 *
 * @package    CodeIgniter Boleto
 * @author     Natan Felles
 * @link       https://github.com/natanfelles/codeigniter-boleto
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 | -------------------------------------------------------------------
 | PADRÃO
 | -------------------------------------------------------------------
 | TRUE = Usar as configurações desse arquivo
 | FALSE = Não usar as configurações desse arquivo
*/
$config['boleto']['padrao'] = TRUE;

/*
 | -------------------------------------------------------------------
 | BANCO
 | -------------------------------------------------------------------
 | bancoob = Banco Cooperativo do Brasil S/A
 | banespa = Banco do Estado de São Paulo
 | banestes =  Banco do Estado do Espírito Santo
 | bb = Banco do Brasil
 | besc = Banco do Estado de Santa Catarina
 | bradesco = Bradesco
 | cef = Caixa Econômica Federal
 | cef_sigcb = Caixa Econômica Federal SIGCB
 | cef_sinco = Caixa Econômica Federal SINCO
 | hsbc = HSBC Bank Brasil
 | itau = Itaú Unibanco
 | nossacaixa = Banco Nossa Caixa
 | real = Banco Real
 | santander_banespa = Santander Banespa
 | sicredi = Banco Cooperativo Sicredi - BANSICREDI
 | sofisa = Banco Sofisa
 | sudameris = Banco Sudameris
 | unibanco = Unibanco
 */
$config['boleto']['banco'] = 'cef';

/*
 | -------------------------------------------------------------------
 | CEDENTE
 | -------------------------------------------------------------------
 */
$config['boleto']['cedente'] = array(
	'nome'    => 'EMPRESA',
	'cpf_cnpj'    => '',
	'agencia' => '0000-0',
	'conta'  => '0000-0',
	'conta_cedente'  => '000000',
	'carteira'  => 'SR',
	'nosso_numero'  => '12345678',
	'endereco' => '',
	'cidade' => 'Cidade',
	'uf' => 'UF',
);

/*
 | -------------------------------------------------------------------
 | DEMONSTRATIVO
 | -------------------------------------------------------------------
 */
$config['boleto']['demonstrativo'] = array(
	'linha1' => '',
	'linha2' => '',
	'linha3' => '',
);

/*
 | -------------------------------------------------------------------
 | INSTRUÇÕES
 | -------------------------------------------------------------------
 */
$config['boleto']['instrucoes'] = array(
	'linha1' => '<br>Não receber após o vencimento',
	'linha2' => '',
	'linha3' => '- Em caso de dúvidas entre em contato conosco: contato@contato.com.br',
	'linha4' => '',
);

/*
 | -------------------------------------------------------------------
 | LOCAL DAS IMAGENS
 | -------------------------------------------------------------------
 */
$config['boleto']['imagens'] = base_url().'assets/img/boleto';