<?php


namespace App\Service;


use Symfony\Component\HttpKernel\KernelInterface;

class SystemManager
{
    protected $settings;

    /**
     * @var KernelInterface
     */
    protected $kernel;

    protected $rfMessages;

    protected $path;

    public function __construct(KernelInterface $kernel, RfMessages $rfMessages)
    {
        $this->kernel = $kernel;
        $this->rfMessages = $rfMessages;
        $this->init();
    }

    protected function init()
    {
        $rootDir = $this->kernel->getProjectDir();
        $filePath = $rootDir . '/rush.xml';

        $this->path = $filePath;

        $settingsRaw = file_get_contents($this->path);
        $xml = new \SimpleXMLElement($settingsRaw);

        $json = json_encode($xml);
        $settings = json_decode($json, TRUE);
        $array = [];
        foreach ($settings['setting'] as $setting) {
            $array = array_merge($array, [$setting['term'] => $setting]);
        }
        $this->settings = $array;
    }


    public function saveSettings($termsValue)
    {
        $str = "<settings>";
        foreach ($termsValue as $term => $value) {
            if ($label = $this->getLabel($term)) {
                $str .= '<setting>';
                $str .= "<term>$term</term>";
                $str .= "<label>$label</label>";
                $str .= "<value>$value</value>";
                $str .= '</setting>';
            }
        }
        $str .= "</settings>";

        $myfile = fopen($this->path, "w") or $this->rfMessages->addError("Unable to open file to save");;

        fwrite($myfile, $str);
        fclose($myfile);
    }

    public function getValue($term)
    {
        if ($setting = $this->get($term)) {
            return $setting['value'];
        }
        return false;
    }

    public function getLabel($term)
    {
        if ($setting = $this->get($term)) {
            return $setting['label'];
        }
        return false;
    }

    public function get($term)
    {
        if (!empty($this->settings)) {
            if (array_key_exists($term, $this->settings)) {
                return $this->settings[$term];
            }
        }
        return false;
    }

    public function getSettings()
    {
        return $this->settings;
    }

}