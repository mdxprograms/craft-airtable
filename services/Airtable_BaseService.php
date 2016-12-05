<?php
/**
 * Airtable plugin for Craft CMS
 *
 * Airtable_Record Service
 *
 * @author    Josh Waller
 * @copyright Copyright (c) 2016 Josh Waller
 * @link      https://www.joshwaller.me
 * @package   Airtable
 * @since     1.0.0
 */

namespace Craft;

class Airtable_BaseService extends BaseApplicationComponent
{
    private $token;
    private $basesAndTables;
    private $tables;
    /**
     *
     * From any other plugin file, call it like this:
     *
     *     craft()->airtable_base->tables()
     */
    public function __construct()
    {
        $settings             = craft()->plugins->getPlugin('airtable')->getSettings();
        $this->token          = $settings->api_key;
        $this->basesAndTables = explode(",", $settings->basesAndTables);
        $this->tables         = array();
        $this->setCurrentData();
    }

    public function endpoint()
    {
        return "https://api.airtable.com/v0/";
    }

    public function token()
    {
        return $this->token;
    }

    public function tables()
    {
        return array_values($this->tables);
    }

    public function getBase($table=null)
    {
        if ($table) {
            return array_search($table, $this->tables);
        }
        return "Please provide a table name";
    }

    private function setCurrentData()
    {
        foreach ($this->basesAndTables as $bt) {
            $base = explode('@', $bt)[0];
            $table = explode('@', $bt)[1];
            $this->tables[$base] = $table;
        }
    }
}
