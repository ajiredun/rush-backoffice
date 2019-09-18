<?php

namespace App\Service;


class SearchParams
{

    protected $sectors;
    protected $currentSector;

    /**
     * SearchParams constructor.
     */
    public function __construct()
    {
        $this->sectors = [];
    }

    public function add($sector_paramName, $value)
    {
        $split = explode('_',$sector_paramName,2);
        $sector = $split[0];
        $paramName = $split[1];

        if (array_key_exists($sector, $this->sectors)) {
            if (array_key_exists($paramName, $this->sectors[$sector])) {
                $this->sectors[$sector][$paramName] = $value;
            } else {
                $this->sectors[$sector] = array_merge($this->sectors[$sector],[$paramName=>$value]);
            }
        } else {
            $this->sectors = array_merge($this->sectors,[$sector=>[]]);
            if (array_key_exists($paramName, $this->sectors[$sector])) {
                $this->sectors[$sector][$paramName] = $value;
            } else {
                $this->sectors[$sector] = array_merge($this->sectors[$sector],[$paramName=>$value]);
            }
        }
    }

    public function getCurrent($paramName)
    {
        return $this->get($this->getCurrentSector(),$paramName);
    }

    public function get($sector, $paramName = null)
    {
        if ($paramName === null) {
            $split = explode('_',$sector,2);
            $sector = $split[0];
            $paramName = $split[1];
        }
        if (array_key_exists($sector, $this->sectors)) {
            if (array_key_exists($paramName, $this->sectors[$sector])) {
                return $this->sectors[$sector][$paramName];
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getCurrentSector()
    {
        return $this->currentSector;
    }

    /**
     * @param mixed $currentSector
     */
    public function setCurrentSector($currentSector): void
    {
        $this->currentSector = $currentSector;
    }

}