<?php
/**
 * Arquivo DataSendTest
 * 
 * Este arquivo armazena os testes da classe DataSend
 * @author David Nunes dos Santos <david_nunesantos@hotmail.com>
 * @version 1.0.0
 * @package tests
 */

require_once(__DIR__ . '/../classes/DataSend.php');

use PHPUnit\Framework\TestCase;

/**
 * Esta classe é responsável por realizar testes na classe DataSend
 * @package tests
 */
class DataSendTest extends TestCase
{
    /**
     * Testa se a classe pode ser criada
     * @access public
     * @return void
     */
    public function testIfClassCanBeCreated()
    {
        $this->assertInstanceOf(DataSend::class, new DataSend());
    }

    /**
     * Testa se a classe possui todos os atributos necessários
     * @access public
     * @return void
     * @dataProvider attributeProvider
     */
    public function testIfClassHasAttributes($attribute)
    {
        $this->assertClassHasAttribute($attribute, DataSend::class);
    }

    /**
     * Prove o nome dos atributos para o teste de atributos
     * @access public
     * @return array[]
     */
    public function attributeProvider()
    {
        return [
            ['idmensagem'], 
            ['ddd'], 
            ['celular'], 
            ['operadora'], 
            ['horario_envio'], 
            ['mensagem'], 
            ['broker_id'], 
            ['motivo_bloqueio'], 
            ['valido']
        ];
    }

}