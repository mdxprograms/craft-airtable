<?php
/**
 * Airtable plugin for Craft CMS
 *
 * Airtable Variable
 *
 * @author    Josh Waller
 * @copyright Copyright (c) 2016 Josh Waller
 * @link      https://www.joshwaller.me
 * @package   Airtable
 * @since     1.0.0
 */

namespace Craft;

class AirtableVariable
{
    /**
     *     {{ craft.airtable.tables() }}
     */
    public function tables()
    {
        return craft()->airtable_base->tables();
    }

    public function getBase($table=null)
    {
        return craft()->airtable_base->getBase($table);
    }

    public function all($table=null)
    {
        return craft()->airtable_record->all($table);
    }

    public function find($table=null, $id=null)
    {
        return craft()->airtable_record->find($table, $id);
    }
}
