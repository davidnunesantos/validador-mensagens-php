<?php
/**
 * Arquivo UploadFile
 * 
 * Este arquivo é iniciado por uma chamada ajax e realiza o upload do arquivo de dados e faz as validações necessárias
 * @author David Nunes dos Santos <david_nunesantos@hotmail.com>
 * @version 1.0.0
 * @package classes
 */

require_once(__DIR__ . '/DataSend.php');
require_once(__DIR__ . '/Validator.php');

/**
 * Esta classe é responsável por montar objetos do tipo UploadFile e realizar as validações necessárias
 * @package classes
 */
class UploadFile 
{
    /**
     * Tipos de arquivo aceitos
     * @access private
     * @var array
     */
    private $_acceptedTypes;

    /**
     * Extensões de arquivos aceitas
     * @access private
     * @var array
     */
    private $_acceptedExtensions;

    /**
     * Armazena uma instancia da classe Validator
     * @access private
     * @var Validator
     */
    private $_validator;

    /**
     * Armazena os dados válidos
     * @access public
     * @var array
     */
    public $valid;

    /**
     * Armazena os dados bloqueados
     * @access public
     * @var array
     */
    public $blocked;

    /**
     * Retorna o array de dados válidos
     * @access public
     * @return array
     */
    public function getValid() 
    {
        return $this->valid;
    }

    /**
     * Retorna o array de dados bloqueados
     * @access public
     * @return array
     */
    public function getBlocker()
    {
        return $this->blocked;
    }

    /**
     * Métodos construtor da classe UploadFile, define alguns parametros iniciais
     * @access public
     * @param bool $is_test Indica se a classe foi chamada atraves do PHPUnit
     * @return void
     */
    public function __construct($is_test = false)
    {
        $this->_acceptedTypes      = array('text/plain', 'text/csv');
        $this->_acceptedExtensions = array('txt', 'csv');
        $this->_validator          = new Validator($is_test);
        $this->valid               = array();
        $this->blocked             = array();
    }

    /**
     * Recebe um arquivo e realiza o upload e validação deste
     * @access public
     * @param mixed $file
     * @return int
     */
    public function upload($file)
    {
        if ($this->_checkFileType($file['type']) || $this->_checkFileExtension(strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)))) {
            if ($this->_readFile($file)) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    /**
     * Verifica se o tipo do arquivo é válido
     * @access private
     * @param string $file_type
     * @return bool
     */
    private function _checkFileType(string $file_type)
    {
        return in_array($file_type, $this->_acceptedTypes);
    }

    /**
     * Verifica se a extensão do arquivo é válida
     * @access private
     * @param string $file_extension
     * @return bool
     */
    private function _checkFileExtension(string $file_extension)
    {
        return in_array($file_extension, $this->_acceptedExtensions);
    }

    /**
     * Realiza a formatação e leitura dos dados do arquivo para fazer a validação
     * @access private
     * @param mixed $file
     * @return bool
     */
    private function _readFile($file)
    {
        $arquivo  = trim(file_get_contents($file['tmp_name']));
        $arquivo  = str_replace("\0", "", $arquivo);
        $arquivo  = str_replace("'", " ", $arquivo);
        $arquivo  = str_replace("\"", " ", $arquivo);
        $conteudo = explode("\n", $arquivo);

        $linhas = array_map('str_getcsv', $conteudo);
    
        if (count($linhas[0]) === 1) {
            $linhas = array_map(function($conteudo) {
                return str_getcsv($conteudo, ";");
            }, $conteudo);
        }

        return $this->_formatData($linhas);
    }

    /**
     * Formata as linhas do arquivo para objetos DataSend e realiza a validação
     * @access private
     * @param mixed $lines
     * @return bool
     */
    private function _formatData($lines)
    {
        foreach ($lines as $columns) {
            if (count($columns) === 6) {
                $this->_validateData(new DataSend($columns[0], $columns[1], $columns[2], $columns[3], $columns[4], $columns[5]));
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Realiza a validação dos dados de um objeto DataSend
     * @access private
     * @param DataSend $data_send
     * @return void
     */
    private function _validateData(DataSend $data_send)
    {
        $data_validated = $this->_validator->validate($data_send, $this->valid);

        if ($data_validated->getDadosValidos()) {
            if (array_key_exists($data_validated->getNumeroCompleto(), $this->valid)) {
                $old_data = $this->valid[$data_validated->getNumeroCompleto()];
                if ($this->_validator->haveShortedTime($data_validated, $old_data)) {
                    $old_data->setDadosValidos(false);
                    $old_data->setMotivoBloqueio($this->_validator->motivos['haveLongerTime']);
                    $this->blocked[] = $old_data;

                    $this->valid[$data_validated->getNumeroCompleto()] = $data_validated;
                } else {
                    $data_validated->setDadosValidos(false);
                    $data_validated->setMotivoBloqueio($this->_validator->motivos['haveLongerTime']);
                    $this->blocked[] = $data_validated;
                }
            } else {
                $this->valid[$data_validated->getNumeroCompleto()] = $data_validated;
            }
        } else {
            $this->blocked[] = $data_validated;
        }
    }

}

// Quando o arquivo é carregado, é verificado se o arquivo foi enviado
if(isset($_FILES["arquivo"]) && $_FILES["arquivo"]['error'] === 0) {
    // Instancia a classe UploadFile
    $uploadFile = new UploadFile();
    $file       = $_FILES['arquivo'];

    try {
        // Envia o arquivo para validação dos dados
        switch ($uploadFile->upload($file)) {
            // 1 - A validação do arquivo foi finalizada ocm sucesso
            case 1:
                echo json_encode(array('status' => true, 'valid' => $uploadFile->valid, 'blocked' => $uploadFile->blocked));
                break;
            // 2 - Alguma das linhas do arquivo não correspondem ao formato exigido
            case 2:
                echo json_encode(array('status' => false, 'erro' => "Algumas linhas do arquivo <b>{$file['name']}</b> não correspondem ao formato exigido"));
                break;
            // 3 - O tipo ou a extensão do arquivo não esta entre os formados válidos
            case 3:
                echo json_encode(array('status' => false, 'erro' => "O tipo ou extensão do arquivo <b>{$file['name']}</b> é inválido, utilize o tipo .txt ou .csv"));
                break;
        }
    } catch (Exception $e) {
        echo json_encode(array('status' => false, 'erro' => 'Ocorreu um erro, tente novamente'));
    }
} else {
    echo json_encode(array('status' => false, 'erro' => 'Selecione um arquivo válido para enviar'));
}