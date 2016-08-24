<?php namespace Strana;

class ConfigHelper {
    /**
     * @var array
     */
    protected $config;

    /**
     * @param array $config
     */
    public function __construct(Array $config)
    {
        $this->config = $config;
        $this->setDefaults();
    }

    /**
     * Set default config values
     */
    protected function setDefaults()
    {
        $get = $_GET;
        if( ! isset($this->config['pageVar']) ){
            $this->config['pageVar'] = 'page';
        }
        $pageVar = $this->config['pageVar'];
        $page = isset($get[$pageVar]) ? (int) $get['page'] : 1;
        $defaults = array(
            'perPage'           =>  20,
            'page'              =>  $page,
            'maximumPages'      =>  5,
            'infiniteScroll'    =>  false,
            'baseUrl'           =>  $this->getBaseUrl(),
        );

        $this->config = array_merge($defaults, $this->config);
    }

    /**
     * @todo
     */ 
    public function getBaseUrl(){
        if( isset($this->config['baseUrl']) ){
            return $this->config['baseUrl'];
        }

        return 
            'http'
            .(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's':'')
            .'://'
            .$_SERVER['SERVER_NAME']
            .(isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80' ? ':'.$_SERVER["SERVER_PORT"]: '')
            .$_SERVER['REQUEST_URL'];
    }

    /**
     * @return mixed
     */
    public function getCurrentPage()
    {
        return $this->config['page'];
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return $this->config['perPage'] * ($this->config['page'] - 1);
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->config['perPage'];
    }

    /**
     * @return mixed
     */
    public function getMaximumPages()
    {
        return $this->config['maximumPages'];
    }

    /**
     * @return mixed
     */
    public function getInfiniteScroll()
    {
        return $this->config['infiniteScroll'];
    }

    /**
     * @param $totalRecords
     * @return float
     */
    public function getTotalPages($totalRecords)
    {
        $pages = $totalRecords / $this->getLimit();
        // If we have decimal value like 2.2 then we need 3 pages, ceil it.
        $pages = ceil($pages);
        return $pages;
    }

    /**
     * @todo
     */ 
    public function getPageVar(){
        return $this->config['pageVar'];
    }

    /**
     * @todo
     */ 
    public function getSelf(){
        return $this->config;
    }

}