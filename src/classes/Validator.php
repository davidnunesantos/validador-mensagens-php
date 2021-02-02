<?php
/**
 * Arquivo Validator
 * 
 * Este arquivo armazena a classe Validator
 * @author David Nunes dos Santos <david_nunesantos@hotmail.com>
 * @version 1.0.0
 * @package classes
 */

/**
 * Esta classe é responsável por montar objetos do tipo Validator e realizar a validação de objetos do tipo DataSend
 * @package classes
 */
class Validator 
{
    /**
     * DDDs válidos no Brasil
     */
    const DDDS_BRASIL = array(11, 12, 13, 14, 15, 16, 17, 18, 19, 21, 22, 24, 27, 28, 31, 32, 33, 34, 35, 37, 38, 41, 42, 43, 44, 45, 46, 47, 48, 49, 51, 53, 54, 55, 61, 62, 63, 64, 65, 66, 67, 68, 69, 71, 73, 74, 75, 77, 79, 81, 82, 83, 84, 85, 86, 87, 88, 89, 91, 92, 93, 94, 95, 96, 97, 98, 99);

    /**
     * DDDs do estado de São Paulo
     */
    const DDDS_SAO_PAULO = array(11, 12, 13, 14, 15, 16, 17, 18, 19);

    /**
     * Horário limite para agendamento de envio
     */
    const TIME_LIMIT = '19:59:59';

    /**
     * Quantidade máxima de caracteres que uma mensagem pode ter
     */
    const CHARACTER_LIMIT = 140;

    /**
     * Endpoint da API que verifica os números em blacklist
     */
    const ENDPOINT_BLACKLIST = 'https://front-test-pg.herokuapp.com/blacklist/';

    /**
     * Brokers de envio disponíveis
     */
    const BROKER = array(
        'VIVO'   => 1,
        'TIM'    => 1,
        'CLARO'  => 2,
        'OI'     => 2,
        'NEXTEL' => 3
    );

    /**
     * Armazena os motivos de bloqueios e suas descrições
     * @access public
     * @var array
     */
    public $motivos;

    /**
     * Indica se a classe esta sendo chamada atraves do PHPUnit
     * @var bool
     */
    public $is_test;

    /**
     * Método construtor da classe Validator
     * @access public
     * @param bool $is_test Indica se a classe foi chamada atraves do PHPUnit
     * @return void
     */
    public function __construct($is_test = false)
    {
        $this->is_test = $is_test;
        $this->motivos = array(
            'isAfterTimeLimit'      => 'O horário de envio da mensagem ultrapassa o horário limite (Limite: ' . self::TIME_LIMIT . ')',
            'exceedsCharacterLimit' => 'O conteúdo da mensagem excede o limite de caracteres (Limite: ' . self::CHARACTER_LIMIT . ')',
            'isInvalidPhone'        => 'O número de DDD ou celular é inválido',
            'isStateOfSaoPaulo'     => 'O DDD pertence ao estado de São Paulo',
            'isInvalidBroker'       => 'Não existe um broker para essa operadora',
            'isOnBlackList'         => 'O número (DDD + Celular) esta na blacklist',
            'haveLongerTime'        => 'Existe um registro com o mesmo número (DDD + Celular) e com a hora de envio menor ou igual'
        );
    }

    /**
     * Realiza a validação completa de um objeto DataSend
     * @access public
     * 
     * @param DataSend        $data_send  Objeto com dados da mensagem
     * @param array[DataSend] $data_valid Array de objetos com dados de mensagens
     * 
     * @return DataSend
     */

    public function validate(DataSend $data_send, $data_valid)
    {
        $data_send->setDadosValidos(false);

        if ($this->isAfterTimeLimit($data_send)) {
            $data_send->setMotivoBloqueio($this->motivos['isAfterTimeLimit']);
        } else if ($this->exceedsCharacterLimit($data_send)) {
            $data_send->setMotivoBloqueio($this->motivos['exceedsCharacterLimit']);
        } else if (!$this->isPhoneValid($data_send)) {
            $data_send->setMotivoBloqueio($this->motivos['isInvalidPhone']);
        } else if ($this->isStateOfSaoPaulo($data_send)) {
            $data_send->setMotivoBloqueio($this->motivos['isStateOfSaoPaulo']);
        } else if (!$this->getBroker($data_send)) {
            $data_send->setMotivoBloqueio($this->motivos['isInvalidBroker']);
        } else if (!array_key_exists($data_send->getNumeroCompleto(), $data_valid) && $this->isOnBlackList($data_send)) {
            $data_send->setMotivoBloqueio($this->motivos['isOnBlackList']);
        } else {
            $data_send->setBrokerId($this->getBroker($data_send));
            $data_send->setDadosValidos(true);
        }

        return $data_send;
    }

    /**
     * Verifica se o horário de envio da mensagem ultrapassa o horário limite
     * @access public
     * @param DataSend $data_send
     * @return bool
     */
    public function isAfterTimeLimit(DataSend $data_send)
    {
        return strtotime($data_send->getHoraEnvio()) > strtotime(self::TIME_LIMIT);
    }

    /**
     * Verifica se o conteúdo da mensagem excede o limite de caracteres
     * @access public
     * @param DataSend $data_send
     * @return bool
     */
    public function exceedsCharacterLimit(DataSend $data_send)
    {
        return strlen($data_send->getMensagem()) > self::CHARACTER_LIMIT;
    }

    /**
     * Verifica se um número de telefone (DDD + Celular) é válido
     * @access public
     * @param DataSend $data_send
     * @return bool
     */
    public function isPhoneValid(DataSend $data_send)
    {
        return $this->isDDDValid($data_send) && $this->isNumberValid($data_send);
    }

    /**
     * Verifica se o número de DDD é válido seguindo as seguintes regras:
     * - Deve ser formado por 2 dígitos númericos
     * - Deve estar na lista de DDDs válidos para o Brasil
     * @access public
     * @param DataSend $data_send
     * @return bool
     */
    public function isDDDValid(DataSend $data_send)
    {
        return strlen($data_send->getNumeroDDD()) === 2 && in_array((int)$data_send->getNumeroDDD(), self::DDDS_BRASIL);
    }

    /**
     * Verifica se o número de celular é válido seguindo as seguintes regras:
     * - Deve ser formado apenas por números
     * - Deve ser formado por 9 dígitos númericos
     * - O primeiro dígido deve ser 9
     * - O segundo dígito deve ser maior do que 6
     * @access public
     * @param DataSend $data_send
     * @return bool
     */
    public function isNumberValid(DataSend $data_send)
    {
        return is_numeric($data_send->getNumeroCelular()) && strlen($data_send->getNumeroCelular()) === 9 && substr($data_send->getNumeroCelular(), 0, 1) == '9' && (int)substr($data_send->getNumeroCelular(), 1, 1) > 6;
    }

    /**
     * Verifica se o DDD é do estado de São Paulo
     * @access public
     * @param DataSend $data_send
     * @return bool
     */
    public function isStateOfSaoPaulo(DataSend $data_send)
    {
        return in_array((int)$data_send->getNumeroDDD(), self::DDDS_SAO_PAULO);
    }

    /**
     * Retorna o ID do broker de acordo com a operadora, ou false
     * @access public
     * @param DataSend $data_send
     * @return int|bool
     */
    public function getBroker(DataSend $data_send)
    {
        return self::BROKER[$data_send->getNomeOperadora()] ?? false;
    }

    /**
     * Verifica se o número (DDD + Celular) esta na blacklist
     * @access public
     * @param DataSend $data_send
     * @return bool
     */
    public function isOnBlackList(DataSend $data_send)
    {
        if (!$this->is_test) {
            $ch = curl_init(self::ENDPOINT_BLACKLIST . $data_send->getNumeroCompleto());
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);
        } else {
            $info['http_code'] = 404;
        }

        return $info['http_code'] == 200 ? true : false;
    }

    /**
     * Verifica se uma nova mensagem com o mesmo número (DDD + Celular) de uma mensagem já validada possui um tempo de envio menor
     * @access public
     * @param DataSend $new_data
     * @param DataSend $old_data
     * @return bool
     */
    public function haveShortedTime(DataSend $new_data, DataSend $old_data)
    {
        return strtotime($new_data->getHoraEnvio()) < strtotime($old_data->getHoraEnvio());
    }

}