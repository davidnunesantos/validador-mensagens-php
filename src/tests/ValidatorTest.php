<?php
/**
 * Arquivo ValidatorTest
 * 
 * Este arquivo armazena os testes da classe Validator
 * @author David Nunes dos Santos <david_nunesantos@hotmail.com>
 * @version 1.0.0
 * @package tests
 */

require_once(__DIR__ . '/../classes/DataSend.php');
require_once(__DIR__ . '/../classes/Validator.php');

use PHPUnit\Framework\TestCase;

/**
 * Esta classe é responsável por realizar testes na classe Validator
 * @package tests
 */
class ValidatorTest extends TestCase
{
    /**
     * Armazena um instância da classe Validator
     * @access private
     * @var Validator
     */
    private $_validator;

    /**
     * Armazena um instância da classe DataSend
     * @access private
     * @var DataSend
     */
    private $_data_send;

    /**
     * Inicializa os parametros para serem utilizados durante os testes
     * @access protected
     * @return void
     */
    protected function setUp(): void
    {
        // O parametro 'true' é passado para o constructor da classe Validator para informar que é o PHPUnit que esta sendo executado
        // Isso serve para que a funcion que valida blacklist não faça uma requisição á API, pois o PHPUnit não permite requisições externas
        $this->_validator = new Validator(true);
        $this->_data_send = new DataSend();
    }

    /**
     * Testa se a classe pode ser criada
     * @access public
     * @return void
     */
    public function testIfClassCanBeCreated()
    {
        $this->assertInstanceOf(Validator::class, $this->_validator);
    }

    /**
     * Testa se a classe possui os atributos necessários
     * @access public
     * @return void
     */
    public function testIfClassHasAttributeMotivos()
    {
        $this->assertClassHasAttribute('motivos', Validator::class);
    }

    /**
     * Testa se a função isAfterTimeLimit retorna TRUE e FALSE corretamente dependendo dos parametros inseridos
     * @access public
     * @return void
     */
    public function testIsAfterTimeLimitFunction()
    {
        $this->_data_send->setHoraEnvio('20:00:00');
        $this->assertTrue($this->_validator->isAfterTimeLimit($this->_data_send));
        $this->_data_send->setHoraEnvio('19:59:59');
        $this->assertFalse($this->_validator->isAfterTimeLimit($this->_data_send));
    }

    /**
     * Testa se a função exceedsCharacterLimit retorna TRUE e FALSE corretamente dependendo dos parametros inseridos
     * @access public
     * @return void
     */
    public function testExceedsCharacterLimitFunction()
    {
        $this->_data_send->setMensagem('Nam at massa nec nunc feugiat elementum ac quis turpis. Donec dictum libero non ex consequat, at molestie turpis fringilla. Phasellus diam est, congue varius lectus vitae, finibus convallis urna');
        $this->assertTrue($this->_validator->exceedsCharacterLimit($this->_data_send));
        $this->_data_send->setMensagem('Nam at massa');
        $this->assertFalse($this->_validator->exceedsCharacterLimit($this->_data_send));
    }

    /**
     * Testa se a função isDDDValid retorna TRUE e FALSE corretamente dependendo dos parametros inseridos
     * @access public
     * @return void
     */
    public function testIsDDDValidFunction()
    {
        $this->_data_send->setNumeroDDD(41);
        $this->assertTrue($this->_validator->isDDDValid($this->_data_send));
        $this->_data_send->setNumeroDDD(01);
        $this->assertFalse($this->_validator->isDDDValid($this->_data_send));
    }

    /**
     * Testa se a função setNumeroCelular retorna TRUE e FALSE corretamente dependendo dos parametros inseridos
     * @access public
     * @return void
     */
    public function testIsNumberValidFunction()
    {
        $this->_data_send->setNumeroCelular('997463830');
        $this->assertTrue($this->_validator->isNumberValid($this->_data_send));
        $this->_data_send->setNumeroCelular('97463830');
        $this->assertFalse($this->_validator->isNumberValid($this->_data_send));
    }

    /**
     * Testa se a função isPhoneValid retorna TRUE e FALSE corretamente dependendo dos parametros inseridos
     * @access public
     * @return void
     */
    public function testIsPhoneValidFunction()
    {
        $this->_data_send->setNumeroDDD(41);
        $this->_data_send->setNumeroCelular('997463830');
        $this->assertTrue($this->_validator->isPhoneValid($this->_data_send));
        $this->_data_send->setNumeroDDD(41);
        $this->_data_send->setNumeroCelular('97463830');
        $this->assertFalse($this->_validator->isPhoneValid($this->_data_send));
    }

    /**
     * Testa se a função isStateOfSaoPaulo retorna TRUE e FALSE corretamente dependendo dos parametros inseridos
     * @access public
     * @return void
     */
    public function testIsStateOfSaoPauloFunction()
    {
        $this->_data_send->setNumeroDDD(11);
        $this->assertTrue($this->_validator->isStateOfSaoPaulo($this->_data_send));
        $this->_data_send->setNumeroDDD(41);
        $this->assertFalse($this->_validator->isStateOfSaoPaulo($this->_data_send));
    }

    /**
     * Testa se a função getBroker retorna o ID do broker ou FALSE corretamente dependendo dos parametros inseridos
     * @access public
     * @return void
     */
    public function testGetBrokerFunction()
    {
        $this->_data_send->setNomeOperadora('TIM');
        $this->assertEquals(1, $this->_validator->getBroker($this->_data_send));
        $this->_data_send->setNomeOperadora('OUTRA');
        $this->assertFalse($this->_validator->getBroker($this->_data_send));
    }

    /**
     * Testa se a função isOnBlackList retorna TRUE corretamente
     * @access public
     * @return void
     */
    public function testIsOnBlackListFunction()
    {
        $this->_data_send->setNumeroCelular(46);
        $this->_data_send->setNumeroCelular('950816645');
        $this->assertFalse($this->_validator->isOnBlackList($this->_data_send));
    }

    /**
     * Testa se a função validate faz a validação dos dados corretamente, de acordo com os parâmetros informados
     * @access public
     * @return void
     */
    public function testValidateFunction()
    {
        $data_send = new DataSend('testIdMessage', 41, '997463830', 'TIM', '12:00:00', 'testContentMessage');
        $this->assertInstanceOf(DataSend::class , $this->_validator->validate($data_send, array()));
        $this->assertTrue($this->_validator->validate($data_send, array())->getDadosValidos());
        $data_send->setNomeOperadora('OUTRA');
        $this->assertFalse($this->_validator->validate($data_send, array())->getDadosValidos());
    }

    /**
     * Testa se a função haveShortedTime retorna TRUE e FALSE corretamente dependendo dos parametros inseridos
     * @access public
     * @return void
     */
    public function testHaveShortedTimeFunction()
    {
        $new_data = new DataSend('testIdMessage', 41, '997463830', 'TIM', '13:00:00', 'testContentMessage');
        $old_data = new DataSend('testIdMessage', 41, '997463830', 'TIM', '14:00:00', 'testContentMessage');

        $this->assertTrue($this->_validator->haveShortedTime($new_data, $old_data));
        $new_data->setHoraEnvio('15:00:00');
        $this->assertFalse($this->_validator->haveShortedTime($new_data, $old_data));
    }

}