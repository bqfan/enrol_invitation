<?php
/**
 * Displays specific report for UCLA stats console.
 *
 * @package    report
 * @subpackage uclastats
 * @copyright  UC Regents
 */

require_once('../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot.'/report/uclastats/report_forms.php');
require_once($CFG->dirroot.'/report/uclastats/locallib.php');
require_once($CFG->dirroot.'/local/ucla/lib.php');

require_login();
$context = get_context_instance(CONTEXT_COURSE, SITEID);
$PAGE->set_context($context);
require_capability('report/uclastats:view', $context);

$reports = get_all_reports();
$report     = required_param('report', PARAM_ALPHAEXT);
$resultid   = optional_param('resultid', null, PARAM_INT);

// make sure user is accessing a valid report
if (!array_key_exists($report, $reports)) {
    print_error('invalidreport', 'report_uclastats');
}

$PAGE->set_url(new moodle_url('/report/uclastats/view.php',
        array('report' => $report)));

admin_externalpage_setup('reportuclastats');

// create report object and render it
require_once($CFG->dirroot . '/report/uclastats/reports/' . $report . '.php');
$report_object = new $report($USER);

// handle if user is trying to export report
$export_type = optional_param('export', false, PARAM_ALPHA);
if (!empty($export_type) && !empty($resultid)) {
    // NOTE: all exports will die after they send their file
    if ($export_type == 'xls') {
        $report_object->export_result_xls($resultid);
    }
}

// handle if user is trying to run a report
$report_form = $report_object->get_run_form();
$params = $report_form->get_data();
if (!empty($params) && confirm_sesskey()) {
    // fail if user cannot run queries
    require_capability('report/uclastats:query', $context);

    // data from form is a object and has 'submitbutton'
    $params = (array) $params;
    unset($params['submitbutton']);

    // run query and then redirect to result page
    $resultid = $report_object->run($params);
    redirect(new moodle_url('/report/uclastats/view.php',
            array('report' => $report, 'resultid' => $resultid)));
}

// if user is viewing a result table, make it sortable
if (!empty($resultid)) {
    setup_js_tablesorter('uclastats-results-table');
}

echo $OUTPUT->header();

$output = $PAGE->get_renderer('report_uclastats');

echo $output->render_header($report);
echo $output->render_report_list($reports, $report);

echo $output->render_report($report_object, $resultid);

echo $OUTPUT->footer();