<?php
/**
 * UCLA stats console base class.
 *
 * @package    report
 * @subpackage uclastats
 * @copyright  UC Regents
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Returns list of all reports available for UCLA stats console.
 *
 * @global object $CFG
 * @return array        An sorted array of report => report name
 */
function get_all_reports() {
    global $CFG;
    $ret_val = array();

    $reports = scandir($CFG->dirroot . '/report/uclastats/reports');
    // remove first two entries, since they are '.' and '..'.
    unset($reports[0]);
    unset($reports[1]);

    // replace text with actual report name
    foreach ($reports as $report) {
        $report_class = basename($report, '.php');
        $ret_val[$report_class] = get_string($report_class, 'report_uclastats');
    }

    collatorlib::asort($ret_val);
    return $ret_val;
}

/**
 * Naming conventions for UCLA stats console report classes
 *
 *  - the name of the class is used as the "name" for the cached result entry in
 *    "ucla_statsconsole" table.
 *  - lang strings that should be defined are:
 *      <class name>: what stats class is querying
 *      <class name>_help: explaination of how stats class is getting data
 *  - results should be indexed and the index names should be defined in lang
 */
abstract class uclastats_base implements renderable {
    /**
     * User who is running report.
     * @var int
     */
    protected $_userid = null;

    /**
     * Constructor
     * @param int $userid   User who is running the report. Used for logging.
     */
    public function __construct($userid) {
        if (is_object($userid)) {
            $userid = $userid->id;
        }
        $this->_userid = $userid;
    }

    /**
     * Generates HTML output for display of cached query results.
     *
     * @params int $current_resultid    Defaults to null. If given, then will
     *                                  highlight given result.
     * @return string                   Returns generated HTML
     */
    public function display_cached_results($current_resultid = null) {
        global $OUTPUT;
        $ret_val = '';

        $ret_val .= html_writer::tag('h3',
                get_string('cached_results_table', 'report_uclastats'),
                array('class' => 'cached-results-table-title'));

        $cached_results = new uclastats_result_list(get_class($this));
        if (empty($cached_results)) {
            $ret_val .= html_writer::tag('p', get_string('nocachedresults', 
                    'admin'), array('class' => 'noresults'));
        } else {
            // now display results table
            $cached_table = new html_table();
            $cached_table->attributes = array('class' =>
                'cached-results-table ' . get_class($this));

            // get first element and get its array keys to generate header
            $header = array('header_param', 'header_results', 'header_lastran',
                'header_actions');

            // generate header
            foreach ($header as $name) {
                $cached_table->head[] = get_string($name, 'report_uclastats');
            }

            // format cached results
            foreach ($cached_results as $index => $result) {
                $row = new html_table_row();

                // if result is currently being viewed, give some styling
                if ($result->id == $current_resultid) {
                    $row->attributes = array('class' => 'current-result');
                }

                $row->cells['param'] = $this->format_cached_params($result->params);
                $row->cells['results'] = $this->format_cached_results($result->results);

                // display information on who ran the query and the timestamp
                $lastran = new stdClass();
                $lastran->who = $result->userfullname;
                $lastran->when = $result->timecreated;
                $row->cells['lastran'] =
                        get_string('lastran', 'report_uclastats', $lastran);

                // TODO: implement result locking/unlocking/deleting
                $row->cells['actions'] = html_writer::link(
                        new moodle_url('/report/uclastats/view.php',
                                array('report' => get_class($this),
                                      'resultid' => $result->id)),
                        get_string('view_results', 'report_uclastats'));

                $cached_table->data[$index] = $row;
            }

            $ret_val .= html_writer::table($cached_table);
        }

        return $ret_val;
    }

    /**
     * Generates HTML output for display of export options for given report 
     * resultid.
     * 
     * @param int $resultid
     * @return string
     */
    public function display_export_options($resultid) {
        global $OUTPUT;
        $export_options = html_writer::start_tag('div',
                array('class' => 'export-options'));
        $export_options .= get_string('export_options', 'report_uclastats');

        // right now, only supporting xls
        $xls_string = get_string('application/vnd.ms-excel', 'mimetypes');
        $icon = html_writer::empty_tag('img',
                array('src' => $OUTPUT->pix_url('f/spreadsheet'),
                      'alt' => $xls_string,
                      'title' => $xls_string));
        $export_options .= html_writer::link(
                new moodle_url('/report/uclastats/view.php',
                        array('report' => get_class($this),
                              'resultid' => $resultid,
                              'export' => 'xls')), $icon);

        $export_options .= html_writer::end_tag('div');
        return $export_options;
    }

    /**
     * Generates HTML output for display of query results with parameters,
     * result table, and other information.
     *
     * Assumes that first row has every column needed to display and that lang
     * strings exist for each key.
     *
     * @params int $resultid    Result to display
     * @return string           Returns generated HTML
     */
    public function display_result($resultid) {
        global $OUTPUT;
        $ret_val = '';

        // do sanity check (
        try {
            $uclastats_result = new uclastats_result($resultid);
        } catch (dml_exception $e) {
            return get_string('nocachedresults','report_uclastats');
        }
        
        // display parameters
        $params = $uclastats_result->params;
        if (!empty($params)) {
            $params_display = $this->format_cached_params($params);
            $ret_val .= html_writer::tag('p', get_string('parameters',
                    'report_uclastats', $params_display),
                    array('class' => 'parameters'));
        }

        $results = $uclastats_result->results;
        if (empty($results)) {
            $ret_val .= html_writer::tag('p', get_string('noresults','admin'),
                    array('class' => 'noresults'));
        } else {
            // now display results table
            $results_table = new html_table();
            $results_table->id = 'uclastats-results-table';
            $results_table->attributes = array('class' => 'results-table ' .
                get_class($this));

            $results_table->head = $uclastats_result->get_header();
            $results_table->data = $results;

            $ret_val .= html_writer::table($results_table);
        }

        // display export options
        $ret_val .= $this->display_export_options($resultid);

        // display information on who ran the query and the timestamp
        $footer_info = new stdClass();
        $footer_info->who = $uclastats_result->userfullname;
        $footer_info->when = $uclastats_result->timecreated;
        $footer = get_string('lastran', 'report_uclastats', $footer_info);
        $ret_val .= html_writer::tag('p', $footer, array('class' => 'lastran'));

        return $ret_val;
    }

    /**
     * Sends result data as a xls file.
     *
     * @params int $resultid    Result to send
     */
    public function export_result_xls($resultid) {
        global $CFG;
        require_once($CFG->dirroot.'/lib/excellib.class.php');

        // do sanity check (
        try {
            $uclastats_result = new uclastats_result($resultid);
        } catch (dml_exception $e) {
            return get_string('nocachedresults','report_uclastats');
        }

        // file name is report name
        $report_name = get_string(get_class($this), 'report_uclastats');
        $filename = clean_filename($report_name . '.xls');
        
        // creating a workbook (use "-" for writing to stdout)
        $workbook = new MoodleExcelWorkbook("-");
        // sending HTTP headers
        $workbook->send($filename);
        // adding the worksheet
        $worksheet = $workbook->add_worksheet($report_name);
        $bold_format = new MoodleExcelFormat($workbook->pear_excel_workbook);
        $bold_format->set_bold(true);

        // add title
        $worksheet->write_string(0, 0, $report_name, $bold_format);

        // add parameters (if any)
        $params = $uclastats_result->params;
        if (!empty($params)) {
            $params_display = $this->format_cached_params($params);
            $worksheet->write_string(1, 0, get_string('parameters',
                    'report_uclastats', $params_display));
        }

        // now go through the result set
        $results = $uclastats_result->results;
        $row = 3; $col = 0;
        if (empty($results)) {
            $worksheet->write_string(2, 0, get_string('noresults','admin'));
        } else {
            // first display table header
            $header = $uclastats_result->get_header();
            foreach ($header as $name) {
                $worksheet->write_string($row, $col, $name, $bold_format);
                ++$col;
            }

            // now go through result set
            foreach ($results as $result) {
                ++$row; $col = 0;
                foreach ($result as $value) {
                    // values might have HTML in them
                    $value = clean_param($value, PARAM_NOTAGS);
                    if (is_numeric($value)) {
                        $worksheet->write_number($row, $col, $value);
                    } else {
                        $worksheet->write_string($row, $col, $value);
                    }
                    ++$col;
                }
            }
        }

        // display information on who ran the query and the timestamp
        $row += 2;
        $footer_info = new stdClass();
        $footer_info->who = $uclastats_result->userfullname;
        $footer_info->when = $uclastats_result->timecreated;
        $footer = get_string('lastran', 'report_uclastats', $footer_info);
        $worksheet->write_string($row, 0, $footer);

        // close the workbook
        $workbook->close();
        exit;
    }

    /**
     * Helper function to figure how to best display parameters column in cached
     * results table.
     *
     * @param array $params
     * @return string
     */
    public function format_cached_params($params) {
        $param_list = array();
        foreach ($params as $name => $value) {
            $param_list[] = get_string($name, 'report_uclastats') . ' = ' .
                    $value;
        }
        return implode(', ', $param_list);
    }

    /**
     * Helper function to figure how to best display results column in cached
     * results table.
     *
     * @param array $results
     * @return string
     */
    public function format_cached_results($results) {
        return count($results);
    }

    /**
     * Returns associated help text for given report.
     *
     * @return string
     */
    public function get_help() {
        return html_writer::tag('p', get_string(get_class($this) .
                '_help', 'report_uclastats'), array('class' => 'report-help'));
    }

    /**
     * Abstract method to return parameters needed to run report.
     *
     * @return array
     */
    public abstract function get_parameters();

    /**
     * Returns either a list of cached results for current report or specified
     * cached results.
     *
     * @global object $DB
     * @param int $resultid     Default is null. If null, then returns a list
     *                          cached results for gieven report. If id
     *                          specified, then returns that specific cached
     *                          results.
     * @return mixed            Returns either a uclastats_result_list or
     *                          uclastats_result.
     */
    public function get_results($resultid = null) {
        global $DB;

        $ret_val = null;
        if (empty($resultid)) {
            // user wants list of cached results
            $ret_val = new uclastats_result_list(get_class($this));
        } else {
            // user wants a specific cached result
            $ret_val = new uclastats_result($resultid);
        }

        return $ret_val;
    }

    /**
     * Returns Moodle form used to display form to run report.
     *
     * @return moodleform
     */
    public function get_run_form() {
        $report_url = new moodle_url('/report/uclastats/view.php',
                        array('report' => get_class($this)));
        $run_form = new runreport_form($report_url->out(),
                array('fields' => $this->get_parameters(),
                      'is_high_load' => $this->is_high_load()),
                'post',
                '',
                array('class' => 'run-form'));
        return $run_form;
    }

    /**
     * Allows reports to indicate if they run complex queries that might take
     * a long time to run or puts a high load on the server. An example of such
     * a query is one that makes extensive use of the mdl_log table, since 
     * none of those columns are indexed.
     *
     * @return boolean  Default return value is false
     */
    public function is_high_load() {
        return false;
    }

    /**
     * Abstract method that needs to be defined by reports.
     *
     * Should validate params and throw an exception if there is an error.
     *
     * NOTE: Do not worry about casting array of objects returned by Moodle's
     * DB API to arrays, because when they are encoded and then decoded to and
     * from JSON, they will be cast as arrays.
     *
     * @throws  moodle_exception
     *
     * @params array $params
     * @return array            Returns an array of results.
     */
    public abstract function query($params);

    /**
     * Runs query for given parameters and caches the results.
     *
     * @throws  moodle_exception
     *
     * @global object $DB
     * @param array $params
     * @return int            Returns cached result id of the query.
     */
    public function run($params) {
        global $DB;

        $results = $this->query($params);        
        $cached_resultid = uclastats_result::save(get_class($this), $params,
                $results, $this->_userid);

        return $cached_resultid;
    }
}

/**
 * Contains a basic set of information needed to display statistics results.
 *
 * Also handles storing and retriving of cached results.
 */
class uclastats_result implements renderable {
    /**
     * Used to cache results of userid to user object lookups. Can be used to
     * cache other types of data.
     * @var array
     */
    protected static $_cache = array();

    /**
     * Stores results array.
     * @var array
     */
    protected $result;

    /**
     * Creates an instance of result object with specified cache result id.
     *
     * @throws dml_exception    Throws exception if result is not found.
     *
     * @global object $DB
     * @param mixed $resultid   If int, then will retrieve cached result. If an
     *                          object, then assumes that result is from
     *                          database.
     */
    public function __construct($result) {
        global $DB;
        if (is_int($result)) {
            $this->result = $DB->get_record('ucla_statsconsole',
                    array('id' => $result), '*', MUST_EXIST);
        } else if (is_object($result)) {
            $this->result = $result;
        } else {
            throw new dml_exception('invalidrecordunknown');
        }
    }

    /**
     * Magic getter function.
     *
     * Does behind the scenes formatting of results from database to have it
     * displayable.
     * 
     * @param string $name
     */
    public function __get($name) {
        switch ($name) {            
            case 'params':
                // stored as json, so decode it
                return json_decode($this->result->params, true);
            case 'results':
                // results might be obtained multiple times
                return $this->decode_results();
            case 'timecreated':
                // give pretty version of timestamp
                return userdate($this->result->timecreated);
            case 'user':
                // give user object
                return $this->get_user($this->result->userid);
            case 'userfullname':
                // give user fullname
                $user = $this->get_user($this->result->userid);
                return fullname($user);
            default:
                return $this->result->$name;
        }
    }

    /**
     * Returns an array of strings to use as the header for displaying the
     * results.
     *
     * @return array
     */
    public function get_header() {
        $ret_val = array();
        // get first element and get its array keys to generate header
        $results = $this->decode_results();
        $header = reset($results);

        // generate header
        foreach ($header as $name => $value) {
            $ret_val[] = get_string($name, 'report_uclastats');
        }

        return $ret_val;
    }

    /**
     * Since the result is encoded as a JSON object, need to decode it. Might
     * be returning the result many times, so cache it.
     *
     * @return array
     */
    private function decode_results() {
        if (!isset(self::$_cache['decode_results'][$this->result->id])) {
            self::$_cache['decode_results']
                    = json_decode($this->result->results, true);
        }
        return self::$_cache['decode_results'];
    }

    /**
     * Queries for user object and tries to use cached result, if any.
     *
     * @global object $DB
     * @param int $userid
     */
    private function get_user($userid) {
        global $DB;
        // cache user object lookups, since there might be many repeats
        if (empty(self::$_cache['user'][$userid])) {
            self::$_cache['user'][$userid] =
                    $DB->get_record('user', array('id' => $userid));
        }
        return self::$_cache['user'][$userid];
    }

    /**
     * Static method to take report results and encode and then save them.
     *
     * @global object $DB
     * @param string $report
     * @param array $params
     * @param array $results
     * @param int $userid
     * @return int              Returns result id of newly created result
     */
    public static function save($report, $params, $results, $userid) {
        global $DB;

        $cache_result = new stdClass();
        $cache_result->name = $report;
        $cache_result->userid = $userid;
        $cache_result->params = json_encode($params);
        $cache_result->results = json_encode($results);
        $cache_result->locked = 0;
        $cache_result->timecreated = time();

        return $DB->insert_record('ucla_statsconsole', $cache_result);
    }
}

/**
 * Class to be used in report renderers and for retrieving list of report
 * results.
 */
class uclastats_result_list implements Iterator, renderable {
    private $position = 0;
    private $array = array();

    /**
     * Retrieves list of cached results for given report.
     *
     * @global type $DB
     * @param string $report
     */
    public function __construct($report) {
        global $DB;
        $this->position = 0;

       $results = $DB->get_records('ucla_statsconsole', 
               array('name' => $report), 'timecreated DESC');

       if (!empty($results)) {
           // cast results as uclastats_result objects
           $index = 0;
           foreach ($results as $result) {
               $this->array[$index] = new uclastats_result($result);
               ++$index;
           }
       }
    }

    function count() {
        return count($this->array);
    }

    function current() {
        return $this->array[$this->position];
    }

    function key() {
        return $this->position;
    }

    function next() {
        ++$this->position;
    }

    function rewind() {
        $this->position = 0;
    }

    function valid() {
        return isset($this->array[$this->position]);
    }
}