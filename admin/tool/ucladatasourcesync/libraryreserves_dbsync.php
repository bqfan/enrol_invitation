<?php
/**
 * Command line script to parse, verify, and update Library reserves entries in the Moodle database.
 *
 * $CFG->libraryreserves_data is defined in the plugin configuration at 
 * Site administration->Plugins->Blocks->Library reserves
 *
 * See CCLE-2312 for details
 **/
require_once('lib.php');

// Check to see that config variable is initialized
$datasource_url = get_config('block_ucla_library_reserves', 'source_url');
if (empty($datasource_url)) {
    die("\n" . get_string('errlrmsglocation', 'tool_ucladatasourcesync') . "\n");
}

// Begin database update
update_libraryreserves_db($datasource_url);

function update_libraryreserves_db($datasource_url) {
    // get global variables
    global $CFG, $DB;

    echo get_string('lrstartnoti', 'tool_ucladatasourcesync');

    $incoming_data = array();

    # read the file into a two-dimensional array
    $lines = file($datasource_url);

    if ($lines === FALSE) {
        die("\n" . get_string('errlrfileopen', 'tool_ucladatasourcesync') . "\n");
    }    
    
    foreach ($lines as $line_num => $line) {
        # stop processing data if we hit the end of the file
        if ($line != "=== EOF ===\n") {
            # remove the newline at the end of each line
            $line = rtrim($line);

            $incoming_data[$line_num] = explode("\t", $line);
        }
    }

    $curfields = $DB->get_records_sql("DESCRIBE {$CFG->prefix}" . "ucla_library_reserves");

    $fields = array();
    foreach ($curfields as $fieldname => $fielddata) {

        // Skip the field 'id'
        if ($fieldname == 'id') {
            continue;
        }

        $fields[$fieldname] = $fieldname;
    }

    $data_incoming = array();

    // Check if all entries have the correct number of columns  
    $num_incoming_data = count($incoming_data);
    for ($row = 1; $row < $num_incoming_data; $row++) {
        if (count($incoming_data[$row]) != count($fields)) {
            die("\n" . get_string('errinvalidrowlen', 'tool_ucladatasourcesync') . "\n");
        }

        // Bind field label to data

        $tabnum = 0;

        foreach ($fields as $tab_num => $field_name) {

            $data = $incoming_data[$row][$tabnum];
            $field = trim($field_name);

            if ($fieldname == 'id') {
                continue;
            }

            if ($field_name == 'srs') {
                $data = sprintf('%09s', $data);
            }

            if ($field_name == 'course_number') {
                $data = ltrim($data, '0');
            }

            $data_incoming[$row][$field] = $data;

            $tabnum++;
        }
    }

    $data = &$data_incoming;

    // Drop table and refill with data
    $DB->delete_records('ucla_library_reserves');

    $insert_count = 0;
    $line = 1;
    $row = new stdClass();
    $index = FALSE;

    $num_data = count($data);
    for ($line; $line < $num_data; $line++) {

        foreach ($data[$line] as $field => $fieldvalue) {
            $row->$field = $fieldvalue;
        }

        try {
            $index = $DB->insert_record('ucla_library_reserves', $row);
        } catch (Exception $e) {
            // Do nothing, to handle cases where rows are invalid beyond norms.  Does not insert row.
        }

        if ($index) {
            $insert_count++;
        }
    }

    if ($insert_count == 0) {
        echo "\n" . get_string('errbcinsert', 'tool_ucladatasourcesync') . "\n";
    } else {
        echo "\n... " . $insert_count . " " . get_string('lrsuccessnoti', 'tool_ucladatasourcesync') . "\n";
    }
}
