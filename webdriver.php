<?php

require __DIR__.'/vendor/autoload.php';

use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;


/**
 * Path para o binário do chromedriver
 */
putenv('webdriver.chrome.driver='.__DIR__.'/bin/chromedriver');

/**
 * Classe para pegar textos de sites com js utilizando o Chromedriver
 */
class webdriver
{
    private $options;
    private $caps;
    private $chrome;
    public  $userDataDir = '/tmp/chromeDir';

    public function __construct()
    {
        $this->options = new ChromeOptions();
        $this->caps = DesiredCapabilities::chrome();
        $this->setOptions();
        $this->setCaps();
        $this->boot();
    }

    public function __destruct()
    {
        return $this->chrome->quit();
    }

    /**
     * Configura as opções de inicialização do Chrome (Browser)
     * @link https://sites.google.com/a/chromium.org/chromedriver/capabilities
     */
    protected function setOptions()
    {
        return $this->options->addArguments([
            'user-data-dir='.$this->userDataDir,
            '--no-sandbox',

            '--disable-default-apps',
            '--no-first-run',
            '--ignore-certificate-errors',
            '--enable-logging',
            '--enable-automation',
            '--password-store=basic',
            '--test-type=webdriver',
            '--safebrowsing-disable-auto-update',
            '--log-level=ALL',
            '--disable-background-networking ',
            '--disable-browser-side-navigation',
            '--disable-client-side-phishing-detection',
            '--disable-hang-monitor',
            '--disable-popup-blocking',
            '--disable-prompt-on-repost',
            '--disable-sync', 
            '--disable-web-resources',
            '--force-fieldtrials=SiteIsolationExtensions/Control',
            '--metrics-recording-only',
            '--use-mock-keychain',

            // 'headless'
            // 'disable-popup-blocking',
        ]);
    }

    /**
     * Configura as capacidades iniciais do Chrome (Browser)
     * @link https://sites.google.com/a/chromium.org/chromedriver/capabilities
     */
    protected function setCaps()
    {
        return $this->caps->setCapability(ChromeOptions::CAPABILITY, $this->options);
    }

    /**
     * Inicia o chromedriver
     */
    public function boot()
    {
        return $this->chrome = ChromeDriver::start($this->caps);
    }

    /**
     * Método para fazer um GET na url informada. 
     * Caso o segundo parâmetro seja informado, o chromedrive vai esperar esse 
     * elemento estar disponível
     * @param  string $url - url que será carregada pelo chromedriver
     * @param  [type] $elem - elemento que será aguardado pelo chromedrive. ex.: input[id="input-chatlist-search"]
     * @return
     */
    public function get(string $url, $elem = null)
    {
        $this->chrome->get($url);
        
        $driver = $this->chrome;

        if(!is_null($elem)) {
            $this->chrome->wait()->until(
                function () use ($driver, $elem) {
                    $elements = $driver->findElements(WebDriverBy::cssSelector($elem));
                    return @count($elements) > 0;
                },
                'Erro ao encontrar o elemento '.$elem
            );
        }
    }

    /**
     * checa se o elemento existe na página
     * @param  string $elem - elemento que será checado. ex.: input[name="rememberMe"]
     * @return bool true se existir, false se não
     */
    public function checkElemento($elem)
    {
        if (@count($this->chrome->findElements(WebDriverBy::cssSelector($elem))) > 0) {
          return true;
        }

        return false;
    }

    public function getText($elem)
    {
        if($this->checkElemento($elem)) {
            return "Texto do Elemento: " . $elem . "\n\n" .
                $this->chrome->findElement(WebDriverBy::className(str_replace('.', '', $elem)))->getText() . "\n" .
                "--------------------------\n\n";
        }

        return false;
    }
}