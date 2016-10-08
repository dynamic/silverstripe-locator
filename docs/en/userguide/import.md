# Importing Locations

For large installations, you can import Location and Category data via the Locator Admin. Simply export as CSV to get the spreadsheet template, fill out the sheet, and import via the Locator admin.

For duplication checks, to update exsiting records rather than always replace the data, create a `Import_ID` column in your spreadsheet with an auto-increment integer. For large uploads, this will allow you to skip already existing records in those cases where your initial import times/errors out.
