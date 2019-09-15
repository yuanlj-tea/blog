<?php

namespace App\Libs;

class CurlRequest
{
    /**
     * @resource cURL handle
     */
    private $_ch;
    /**
     * @array curl_set_option
     */
    public $options;
    /**
     * @var
     */
    private $error;

    private static $instance = NULL;

    private $default_options = array(
        CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_AUTOREFERER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HEADER => false,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:5.0) Gecko/20110619 Firefox/5.0'
    );

    public function __construct(array $options = array())
    {
        try {
            $this->_ch = curl_init();
            $options = $this->default_options + $options;
            $this->setOptions($options);
        } catch (\Exception $e) {
            throw new \Exception('Curl extension not installed');
        }
    }

    public function _exec($url)
    {
        $this->setOption(CURLOPT_URL, $url);

        $content = curl_exec($this->_ch);
        if (!curl_errno($this->_ch)) {
            return $content;
        } else {
            $this->error = curl_error($this->_ch);
            return false;
        }
    }

    /**
     * @param null $offset
     * @return mixed
     */
    public function getInfo($offset = NULL)
    {
        return curl_getinfo($this->_ch, $offset);
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param $url
     * @param array|NULL $params
     * @return bool|mixed
     */
    public function get($url, array $params = NULL)
    {
        $this->setOption(CURLOPT_HTTPGET, true);
        return $this->_exec($this->buildUrl($url, $params));
    }

    /**
     * POST Request
     *
     * @param $url
     * @param null $params
     * @return bool|mixed
     */
    public function post($url, $params = NULL)
    {
        $this->setOption(CURLOPT_POST, true);
        if(!empty($params)){
            $this->setOption(CURLOPT_POSTFIELDS, $params);
        }
        return $this->_exec($url);
    }

    /**
     * PUT Request
     *
     * @param $url
     * @param $data
     * @return bool|mixed
     */
    public function put($url, $data)
    {
        $this->setOption(CURLOPT_CUSTOMREQUEST, 'PUT');
        $this->setOption(CURLOPT_POSTFIELDS, $data);
        return $this->_exec($url);
    }

    /**
     * DELETE Request
     *
     * @param $url
     * @return bool|mixed
     */
    public function delete($url)
    {
        $this->setOption(CURLOPT_CUSTOMREQUEST, 'DELETE');
        return $this->_exec($url);
    }

    /**
     * Send Request By Type
     *
     * @param $url
     * @param string $type
     * @param array $params
     * @return mixed
     */
    public function sendRequest($url, $type = 'get', array $params = NULL)
    {
        $type = strtolower($type);
        return $this->$type($url, $params);
    }

    /**
     * @param $url
     * @param array $data
     * @return string
     */
    public function buildUrl($url, array $data = NULL)
    {
        $parsed = parse_url($url);

        if (isset($parsed['query'])) {
            parse_str($parsed['query'], $parsed['query']);
        } else {
            $parsed['query'] = array();
        }

        $data = (array)$data;

        if (isset($parsed['query'])) {
            $params = array_merge($parsed['query'], $data);
        } else {
            $params = $data;
        }

        $parsed['query'] = ($params) ? '?' . http_build_query($params) : '';

        if (!isset($parsed['path'])) {
            $parsed['path'] = '/';
        }

        $port = '';
        if (isset($parsed['port'])) {
            $port = ':' . $parsed['port'];
        }
        return $parsed['scheme'] . '://' . $parsed['host'] . $port . $parsed['path'] . $parsed['query'];
    }

    public function setOptions($options = array())
    {
        curl_setopt_array($this->_ch, $options);
        return $this;
    }

    /**
     * Set Curl Option by key=>value
     *
     * @param $option
     * @param $value
     * @return $this
     */
    public function setOption($option, $value)
    {
        curl_setopt($this->_ch, $option, $value);
        return $this;
    }

    /**
     * Set Request header
     *
     * @param $header
     * @return $this
     */
    public function setHeaders($header)
    {
        if (is_array($header)) {
            $out = array();
            foreach ($header as $k => $v) {
                $out[] = $k . ': ' . $v;
            }
            $header = $out;
        }
        $this->setOption(CURLOPT_HTTPHEADER, $header);
        return $this;
    }

    public function __destruct()
    {
        curl_close($this->_ch);
    }

    /**
     * @param array $options
     * @return CurlRequest
     */
    public static function getInstance(array $options = array())
    {
        if (self::$instance == NULL) {
            self::$instance = new self($options);
        }
        return self::$instance;
    }
}