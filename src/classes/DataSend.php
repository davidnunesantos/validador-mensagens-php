<?php
/**
 * Arquivo DataSend
 * 
 * Este arquivo armazena a classe DataSend
 * @author David Nunes dos Santos <david_nunesantos@hotmail.com>
 * @version 1.0.0
 * @package classes
 */

/**
 * Esta classe é responsável por montar objetos do tipo DataSend
 * @package classes
 */
class DataSend 
{
    /**
     * ID da mensagem
     * @access public
     * @var string
     */ 
    public $idmensagem;

    /**
     * Número do DDD
     * @access public
     * @var int
     */
    public $ddd;

    /**
     * Número do celular
     * @access public
     * @var string
     */
    public $celular;

    /**
     * Nome da operadora
     * @access public
     * @var string
     */
    public $operadora;

    /**
     * Horário programado para envio
     * @access public
     * @var string
     */
    public $horario_envio;

    /**
     * Conteúdo da mensagem
     * @access public
     * @var string
     */
    public $mensagem;

    /**
     * ID do broker de envio
     * @access public
     * @var int
     */
    public $broker_id;

    /**
     * Descrição do motivo do bloqueio
     * @access public
     * @var string
     */
    public $motivo_bloqueio;

    /**
     * Indica se a mensagem é vaálida
     * @access public
     * @var bool
     */
    public $valido;

    /**
     * Pega o ID da mensagem
     * @access public
     * @return string
     */
    public function getIDMensagem()
    {
        return $this->idmensagem;
    }

    /**
     * Pega o número do DDD
     * @access public
     * @return string
     */
    public function getNumeroDDD()
    {
        return $this->ddd;
    }

    /**
     * Pega o número do Celular
     * @access public
     * @return string
     */
    public function getNumeroCelular()
    {
        return $this->celular;
    }

    /**
     * Pega o nome da operadora
     * @access public
     * @return string
     */
    public function getNomeOperadora()
    {
        return strtoupper($this->operadora);
    }

    /**
     * Pega o horário de envio
     * @access public
     * @return string
     */
    public function getHoraEnvio()
    {
        return $this->horario_envio;
    }

    /**
     * Pega o conteúdo da mensagem
     * @access public
     * @return string
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * Pega o ID do broker
     * @access public
     * @return string
     */
    public function getBrokerID()
    {
        return $this->broker_id;
    }

    /**
     * Pega o telefone completo (DDD + Celular)
     * @access public
     * @return string
     */
    public function getNumeroCompleto()
    {
        return $this->getNumeroDDD() . $this->getNumeroCelular();
    }

    /**
     * Pega o motivo do bloqueio
     * @access public
     * @return string
     */
    public function getMotivoBloqueio()
    {
        return $this->motivo_bloqueio;
    }

    /**
     * Pega a configuração de dados válidos
     * @access public
     * @return string
     */
    public function getDadosValidos()
    {
        return $this->valido;
    }

    /**
     * Define um ID da mensagem
     * @access public
     * 
     * @param string $idmensagem
     * 
     * @return void
     */
    public function setIDMensagem(string $idmensagem)
    {
        $this->idmensagem = $idmensagem;
    }

    /**
     * Define um número de DDD
     * @access public
     * 
     * @param int $numeroddd
     * 
     * @return void
     */
    public function setNumeroDDD(int $numeroddd)
    {
        $this->ddd = $numeroddd;
    }

    /**
     * Define um número de celular
     * @access public
     * 
     * @param string $numerocelular
     * 
     * @return void
     */
    public function setNumeroCelular(string $numerocelular)
    {
        $this->celular = $numerocelular;
    }

    /**
     * Define um nome de operadora
     * @access public
     * 
     * @param string $nomeoperadora
     * 
     * @return void
     */
    public function setNomeOperadora(string $nomeoperadora)
    {
        $this->operadora = $nomeoperadora;
    }

    /**
     * Define um horário de envio da mensagem
     * @access public
     * 
     * @param string $hora_envio
     * 
     * @return void
     */
    public function setHoraEnvio(string $hora_envio) 
    {
        $this->horario_envio = $hora_envio;
    }

    /**
     * Define uma mensagem
     * @access public
     * 
     * @param string $mensagem
     * 
     * @return void
     */
    public function setMensagem(string $mensagem)
    {
        $this->mensagem = $mensagem;
    }

    /**
     * Define o ID do broker de envio
     * @access public
     * 
     * @param int $broker_id
     * 
     * @return void
     */
    public function setBrokerId(int $broker_id)
    {
        $this->broker_id = $broker_id;
    }

    /**
     * Define um motivo de bloqueio
     * @access public
     * 
     * @param string $motivo_bloqueio
     * 
     * @return void
     */
    public function setMotivoBloqueio(string $motivo_bloqueio)
    {
        $this->motivo_bloqueio = $motivo_bloqueio;
    }

    /**
     * Define se os dados são válidos ou não
     * @access public
     * 
     * @param bool $valido
     * 
     * @return void
     */
    public function setDadosValidos(bool $valido)
    {
        $this->valido = $valido;
    }

    /**
     * Método construtor da classe DataSend
     * @access public
     * 
     * @param string $idmensagem    ID da mesagem
     * @param int    $ddd           Número do DDD
     * @param string $celular       Número do celular
     * @param string $operadora     Nome da operadora
     * @param string $horario_envio Horario de envio da mensagem
     * @param string $mensagem      Conteúdo da mensagem
     * 
     * @return void
     */
    public function __construct(string $idmensagem = null, int $ddd = null, string $celular = null, string $operadora = null, string $horario_envio = null, string $mensagem = null)
    {
        $this->idmensagem      = $idmensagem;
        $this->ddd             = $ddd;
        $this->celular         = $celular;
        $this->operadora       = $operadora;
        $this->horario_envio   = $horario_envio;
        $this->mensagem        = $mensagem;
        $this->broker_id       = null;
        $this->motivo_bloqueio = null;
        $this->valido          = null;
    }

}