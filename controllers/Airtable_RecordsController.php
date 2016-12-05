<?php
/**
 * Airtable plugin for Craft CMS
 *
 * Airtable_Records Controller
 *
 * --snip--
 * Generally speaking, controllers are the middlemen between the front end of the CP/website and your plugin’s
 * services. They contain action methods which handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering post data, saving it on a model,
 * passing the model off to a service, and then responding to the request appropriately depending on the service
 * method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what the method does (for example,
 * actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 * --snip--
 *
 * @author    Josh Waller
 * @copyright Copyright (c) 2016 Josh Waller
 * @link      https://www.joshwaller.me
 * @package   Airtable
 * @since     1.0.0
 */

namespace Craft;

class Airtable_RecordsController extends BaseController
{

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     * @access protected
     */
    protected $allowAnonymous = true;

    // GET only action = airtable/records/all
    public function actionAll()
    {
        if (craft()->request->isAjaxRequest()) {
            $records = craft()->airtable_record->all();
            return $this->returnJson($records);
        }
    }

    // GET only action = airtable/records/find
    public function actionFind()
    {
        if (craft()->request->isAjaxRequest()) {
            $table = craft()->request->getParam('table');
            $id = craft()->request->getParam('recordId');
            $records = craft()->airtable_record->find($table, $recordId);
            return $this->returnJson($records);
        }
    }

    // POST action = airtable/records/save
    public function actionSave()
    {
        $this->requirePostRequest();
        $formData = craft()->request->getPost();
        $result   = craft()->airtable_record->save($formData);

        if (craft()->request->isAjaxRequest()) {
            $this->returnJson($result);
        } else {
            $this->redirectToPostedUrl($result);
        }
    }

    // POST action = airtable/records/update
    public function actionUpdate()
    {
        $this->requirePostRequest();
        $formData = craft()->request->getPost();
        $result   = craft()->airtable_record->update($formData);

        if (craft()->request->isAjaxRequest()) {
            $this->returnJson($result);
        } else {
            $this->redirectToPostedUrl($result);
        }
    }

    // POST action = airtable/records/delete
    public function actionDelete()
    {
        $this->requirePostRequest();
        $id = craft()->request->getPost('recordId');
        $result = craft()->airtable_record->delete($id);

        if (craft()->request->isAjaxRequest()) {
            $this->returnJson($result);
        } else {
            $this->redirectToPostedUrl($result);
        }
    }
}
