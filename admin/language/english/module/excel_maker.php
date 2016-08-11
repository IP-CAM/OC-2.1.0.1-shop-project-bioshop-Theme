<?php
// Heading
$_['heading_title']          = 'Excel Maker';
$_['setting_import']         = 'Setting import';
$_['setting_export']         = 'Setting export';

// Text
$_['text_success']           = 'Success: You have successfully imported your categories and products!';
$_['text_nochange']          = 'No server data has been changed.';
$_['text_log_details']       = 'See also \'System &gt; Error Logs\' for more details.';
$_['text_modified_ok']       = 'The command had been executed!';
$_['text_modified_error']    = 'The settings had not been modified!';
$_['text_error_max_row']     = 'The parameter cannot be less than 30!';
$_['text_row_number_zero']   = 'First row and end row must more zero';
$_['text_export_started']    = 'Export started!';
$_['text_help_export']       = 'You must input settings export!';
$_['text_settings_ok']       = 'Settings have been modified!';


// Entry
$_['entry_restore']          = 'Import from spreadsheet file:';
$_['entry_description']      = 'Use this function to export or import all your categories and products to or from a XLSX spreadsheet file.';
$_['import_title']           = 'Use this function to settings import  your categories and products to or from a XLSX spreadsheet file.';
$_['export_title']           = 'Use this function to settings export  your categories and products to in a XLSX spreadsheet file.';

// Settings import
$_['image_field']            = 'Images';
$_['name_field']             = 'Name';
$_['model_field']            = 'Model';
$_['price_field']            = 'Price';
$_['guantity_field']         = 'Quantity';
$_['statusenabled_field']    = 'Status';
$_['sku_field']              = 'Article (SKU, source manufacturer)';
$_['manufacturer_field']     = 'Manufacturer';
$_['description_field']      = 'Description';
$_['categories_field']       = 'Categories';
$_['row_size']               = 'Select row for import';
$_['row_size_export']        = 'Select row for export';
$_['not_data']               = 'Not data';
$_['not_number']             = 'Number is not chosen';
$_['not_image']              = 'Not image';
$_['not_model']              = 'Not model';
$_['max_execution_time']     = 'Max execution time for php';
$_['time_description']       = 'sec';

//Settings export
$_['number_column']          = 'Use this function for choice about accommodation of columns';


// Error
$_['error_permission']          = 'Warning: You do not have permission to modify exports/imports!';
$_['error_action']              = 'You cannot execute this action!';
$_['error_upload']              = 'Uploaded file is not a valid spreadsheet file or its values are not in the expected formats!';
$_['error_sheet_count']         = 'Export/Import: Invalid number of worksheets';
$_['error_categories_header']   = 'Export/Import: Invalid header in the Categories worksheet';
$_['error_select_file']         = 'Export/Import: Please select a file before clicking \'Import\'';
$_['error_post_max_size']       = 'Export/Import: File size is greater than %1 (see PHP setting \'post_max_size\')';
$_['error_upload_max_filesize'] = 'Export/Import: File size is greater than %1 (see PHP setting \'upload_max_filesize\')';
$_['error_select_field']        = 'Error: You have not chosen any field!';
$_['error_name_field']          = 'Error: The name of a field repeat some times!';
$_['error_separator_import']    = 'Error: The separator column not found!';
$_['error_incorrect_type_file'] = 'Error: Incorrect type file!';
$_['error_number_field']        = 'Error: The number of a field repeat some times!';
$_['error_interrupt_import']    = 'Error: The import was interrupted. You need set setting and push button \"Enter\" and after push button \"Import\"!';

// Button labels
$_['button_import']     = 'Import';
$_['button_export']     = 'Export';
$_['button_enter']     = 'Enter';
?>