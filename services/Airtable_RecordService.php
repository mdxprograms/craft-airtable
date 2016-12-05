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

class Airtable_RecordService extends BaseApplicationComponent
{
    /**
     * This function can literally be anything you want, and you can have as many service functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     craft()->airtable_record->exampleService()
     */
    private $token;
    private $tables;
    private $endpoint;

    public function __construct()
    {
        $this->token    = craft()->airtable_base->token();
        $this->tables   = craft()->airtable_base->tables();
        $this->endpoint = craft()->airtable_base->endpoint();
    }

    // ORM functions
    public function all($table=null)
    {
        return $this->fetch($table);
    }

    public function find($table=null, $id=null)
    {
        return $this->fetch($table, $id);
    }

    public function save($data=null)
    {
        return $this->post($data);
    }

    public function update($data=null)
    {
        return $this->put($data);
    }

    public function delete($table=null, $id=null)
    {
        return $this->destroy($table, $id);
    }

    // http handlers
    private function fetch($table, $id=null)
    {
        if (in_array($table, $this->tables)) {
            $base    = craft()->airtable_base->getBase($table);
            $headers = array(
                'Accept: application/json',
                'Content-Type: application/json',
                "Authorization: Bearer $this->token"
            );

            if ($id) {
                $endpoint = $this->endpoint . $base . '/' . $table . '/' . $id;
            } else {
                $endpoint = $this->endpoint . $base . '/' . $table;
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $returnData = curl_exec($ch);
            $results = json_decode($returnData);
            curl_close($ch);

            if ($id) {
                return $results;
            } else {
                return $results->records;
            }
        }
        return "$table does not exist in Airtable";
    }

    private function post($data)
    {
        if (in_array($data['table'], $this->tables)) {
            $base    = craft()->airtable_base->getBase($data['table']);
            if ($data['fields']) {
                $headers = array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    "Authorization: Bearer $this->token"
                );
                $endpoint = $this->endpoint . $base . '/' . $data['table'];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $endpoint);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(
                    array('fields' => $data['fields']))
                );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $returnData = curl_exec ($ch);
                $result = json_decode($returnData);
                curl_close ($ch);

                return $result;
            }
            return "Must supply a fields array with form data: name='fields[First Name]'";
        }
        return $data['table'] . "does not exist in Airtable";
    }

    private function put($data)
    {
        if (in_array($data['table'], $this->tables)) {
            $base    = craft()->airtable_base->getBase($data['table']);
            if ($data['fields']) {
                $headers = array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    "Authorization: Bearer $this->token"
                );
                $endpoint = $this->endpoint . $base . '/' . $data['table'];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $endpoint);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(
                    array('fields' => $data['fields']))
                );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $returnData = curl_exec ($ch);
                $result = json_decode($returnData);
                curl_close ($ch);

                return $result;
            }
            return "Must supply a fields array with form data: name='fields[First Name]'";
        }
        return $data['table'] . "does not exist in Airtable";
    }

    private function destroy($table, $id)
    {
        if (in_array($table, $this->tables)) {
            $base    = craft()->airtable_base->getBase($table);
            if ($id) {
                $headers = array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    "Authorization: Bearer $this->token"
                );
                $endpoint = $this->endpoint . $base . '/' . $table . '/' . $id;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $endpoint);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $returnData = curl_exec ($ch);
                $result = json_decode($returnData);
                curl_close ($ch);

                return $result;
            }
            return "Must supply a table and an id";
        }
        return "$table does not exist in Airtable";
    }
}
