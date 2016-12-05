# Airtable plugin for Craft CMS

Use Airtable bases in Craft

![Screenshot](http://www.chromegeek.com/wp-content/uploads/2016/02/Airtable-official-logo.png)

## Installation

To install Airtable, follow these steps:

1. Download & unzip the file and place the `airtable` directory into your `craft/plugins` directory
2.  -OR- do a `git clone https://github.com/mdxprograms/airtable.git` directly into your `craft/plugins` folder.  You can then update it with `git pull`
3.  -OR- install with Composer via `composer require mdxprograms/airtable`
4. Install plugin in the Craft Control Panel under Settings > Plugins
5. The plugin folder should be named `airtable` for Craft to see it.  GitHub recently started appending `-master` (the branch name) to the name of the folder for zip file downloads.

Airtable works on Craft 2.4.x and Craft 2.5.x.

## Airtable Overview

This plugin adds the ability to integrate your airtable bases and tables into
craft cms.

## Configuring Airtable

To add your settings, go to settings->plugins->airtable in craft admin panel.

1. You will need to supply your api key
2. Bases and Tables input takes the base id and then the table name.

Ex: `appSdasdfindin@Products`

You may add more by separating your entries with a `,`

Ex: `appSdasdfindin@Products,appSdasdfindin@Categories`

## Using Airtable

Once your settings are saved you will have access to a full crud api and some
template variables as well.

### Twig template variables
Find All records in a table:
`craft.airtable.all('your_table_name')`

Find a single record within a table:
`craft.airtable.find('your_table_name', 'your_record_id')`

List tables:
`craft.airtable.tables()`

Get a specific base by associated table:
`craft.airtable.getBase('your_table_name')`

### API CRUD and form submissions
Find All records (table name is required as a parameter):
`GET: airtable/records/all`

Find a single record within a table (table name and record id are required parameters):
`GET: airtable/records/find`

Save a record using a custom form:
NOTE: you will need to supply a hidden field with the `name="table"` with your
table name as the value.
All form elements that you would like to post to will need to be added with
`name="fields[your_field_name]"`

You can also use the update action using the same form setup by just replacing
the hidden action field value to: `airtable/records/update` and add a hidden field
`name="recordId"` with the current records id as the value.

Example form save below:
```
<form method="post" action="" accept-charset="UTF-8">
  <input type="hidden" name="action" value="airtable/records/save">
  <input type="hidden" name="table" value="Candidates">

  <input type="email" name="fields[Email]" id="email" placeholder="Email" required>
  <input type="text" name="fields[First Name]" id="first_name" placeholder="First Name" required>
  <input type="text" name="fields[Last Name]" id="last_name" placeholder="Last Name" required>
  <input type="tel" name="fields[Phone]" id="phone" placeholder="Phone">
  <input type="text" name="fields[Website]" id="website" placeholder="website">
  <textarea name="fields[Where did you hear about us]" rows="8" cols="80" placeholder="Where did you hear about us?"></textarea>

  <input class="btn submit" type="submit" value="{{ 'Submit'|t }}">
</form>
```

Delete record (`recordId` must be supplied via post data):
`POST: airtable/records/delete`

## Airtable Roadmap

Some things to do, and ideas for potential features:

* Generate forms based on table fields with a twig template generated

## Airtable Changelog

### 1.0.0 -- 2016.12.5

* Initial release

Brought to you by [Josh Waller](https://www.joshwaller.me)
