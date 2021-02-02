<?php
/**
 * Arquivo UploadFileTest
 * 
 * Este arquivo armazena os testes da classe UploadFile
 * @author David Nunes dos Santos <david_nunesantos@hotmail.com>
 * @version 1.0.0
 * @package tests
 */

require_once(__DIR__ . '/../classes/UploadFile.php');

use PHPUnit\Framework\TestCase;

/**
 * Esta classe é responsável por realizar testes na classe UploadFile
 * @package tests
 */
class UploadFileTest extends TestCase
{
    /**
     * Armazena uma instância da classe UploadFile
     * @access private
     * @var UploadFile
     */
    private $_upload_file;

    /**
     * Inicializa os parametros para serem utilizados durante os testes
     * @access protected
     * @return void
     */
    protected function setUp(): void
    {
        // O parametro 'true' é passado para o constructor da classe UploadFile para informar que é o PHPUnit que esta sendo executado
        // Isso serve para que a funcion que valida blacklist não faça uma requisição à API, pois o PHPUnit não permite requisições externas
        $this->_upload_file = new UploadFile(true);
    }

    /**
     * Testa se a classe pode ser criada
     * @access public
     * @return void
     */
    public function testIfClassCanBeCreated()
    {
        $this->assertInstanceOf(UploadFile::class, $this->_upload_file);
    }

    /**
     * Testa se a classe possui todos os atributos necessários
     * @access public
     * @return void
     * @dataProvider attributeProvider
     */
    public function testIfClassHasAttributes($attribute)
    {
        $this->assertClassHasAttribute($attribute, UploadFile::class);
    }

    /**
     * Testa se a função upload retorna corretamente os dados de acordo com os parâmetros informados
     * @access public
     * @return void
     */
    public function testUploadFunction()
    {
        $this->assertEquals(1, $this->_upload_file->upload(array('type' => 'text/csv', 'tmp_name' => __DIR__ . '/../public/example_file.txt')));
        $this->assertEquals(2, $this->_upload_file->upload(array('type' => 'text/csv', 'tmp_name' => __DIR__ . '/../public/example_file_invalid.txt')));
        $this->assertEquals(3, $this->_upload_file->upload(array('type' => 'image/png', 'name' => 'test.png', 'tmp_name' => __DIR__ . '/../public/example_file.txt')));
    }

    /**
     * Prove o nome dos atributos para o teste de atributos
     * @access public
     * @return array[]
     */
    public function attributeProvider()
    {
        return [
            ['_acceptedTypes'], 
            ['_acceptedExtensions'], 
            ['_validator'], 
            ['valid'], 
            ['blocked']
        ];
    }

}