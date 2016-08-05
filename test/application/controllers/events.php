<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
	{
		show_404();
	}
    
    public function news()
    {
		$vars = array('page' => array('title' => 'News &amp; Signature Events'));

        // Get 3 upcoming events
        $vars['upcoming_events'] = $this->event->get_events(date('Y-m-d'), null, 3);

        // Load events CSS file
        $vars['page']['css'][] = '/assets/templates/' . GLOBAL_TEMPLATE . '/css/events.css';

		$this->load->vars($vars);
		
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/header');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/events/news');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/footer');
    }
    
    public function calendar($year = null, $month = null)
    {
        // Set default year and month if absent
        if (is_null($year) || !is_numeric($year) || (int)$year != $year || $year < 2013) $year = date('Y');
        if (is_null($month) || !is_numeric($month) || (int)$month != $month || $month < 1 || $month > 12) $month = ($year == date('Y') ? date('n') : 1);

        // Get other values from year and month
        // Timestamps
        $fom = mktime(0, 0, 0, $month, 1, $year);    // First of the month
        $eom = mktime(0, 0, 0, $month + 1, 0, $year);    // End of the month
        // Day-of-week values
        $dow_fom = date('w', $fom);   // First of the month
        $dow_eom = date('w', $eom);   // End of the month
        // Last and next month values
        $lm = mktime(0, 0, 0, $month - 1, 1, $year);
        $nm = mktime(0, 0, 0, $month + 1, 1, $year);

        // Determine calendar start (the Sunday before 1st of month)
        $cal          = array();
        $cal['month'] = $month;
        $cal['year']  = $year;
        $cal['days']  = date('j', $eom);
        $cal['start'] = mktime(0, 0, 0, $month, 1 - $dow_fom, $year);
        $cal['end']   = mktime(0, 0, 0, $month + 1, 6 - $dow_eom, $year);

        // Set previous and next month values
        $cal['prev'] = array();
        $cal['next'] = array();
        $cal['prev']['year']    = date('Y', $lm);
        $cal['prev']['month']   = date('n', $lm);
        $cal['next']['year']    = date('Y', $nm);
        $cal['next']['month']   = date('n', $nm);
        if ($cal['prev']['year'] <= 2012) $cal['prev'] = null;

        // Get days of the week
        $cal['dows'] = array();
        $_ts         = strtotime('next Sunday'); // get next Sunday
        for ($_x = 0; $_x < 7; $_x++)
        {
            $cal['dows'][] = strftime('%A', $_ts);
            $_ts = strtotime('+1 day', $_ts);
        }

        // Get events
        $events = $this->event->get_events(date('Y-m-d', $cal['start']), date('Y-m-d', $cal['end']));

		$vars = array(
            'page'      => array(
                'title' => date('F Y', mktime(0, 0, 0, $cal['month'], 1, $cal['year'])). ' Events Calendar',
                'css'   => array(
                    '/assets/templates/' . GLOBAL_TEMPLATE . '/css/calendar.css',
                    '/assets/templates/' . GLOBAL_TEMPLATE . '/css/events.css',
                ),
            ),
            'cal'       => $cal,
            'events'    => $events
        );
		
		$this->load->vars($vars);
		
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/header');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/events/calendar');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/footer');
    }
    
    public function info($field, $id, $year = null, $month = null)
    {
        // Pull data based on field provided (auto)
        switch ($field)
        {
            case 'id':
                $event = $this->event->get_event_by_id($id);
                break;
            case 'slug':
            default:
                $event = $this->event->get_event($id, $year, $month);
        }

        // Determine settings based on number of records found
        if (empty($event))
        {
            // Set variables
            $view  = 'event_not_found';
            $title = 'Event Not Found';

            // Throw 404 error
            header('HTTP/1.1 404 Not Found');
        }
        else
        {
            // Set variables
            $view  = 'info';
            $title = $event['name'];
        }

        // Load page variables
        $vars = array(
            'page' => array(
                'title' => $title,
                'js' => array(
                    '//maps.googleapis.com/maps/api/js?key=' . API_KEY_GOOGLE_MAPS
                ),
                'css' => array(
                    '/assets/templates/' . GLOBAL_TEMPLATE . '/css/events.css',
                ),
            ),
            'event' => $event,
        );

        $this->load->vars($vars);
		
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/header');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/events/scripts/popup');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/events/' . $view);
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/footer');
    }

    public function ical_event($slug, $year = null, $month = null)
    {
        // Load iCalendar helper
        $this->load->helper('ical_helper');

        // Get event data
        $event = $this->event->get_event($slug, $year, $month);

        // Pass header type
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: inline; filename=' . $slug . '.ics');

        // Build calendar
        $output = ical_build_calendar(array($event), $event['name']);

        // Load output into view
        $this->load->vars(array(
            'output' => $output
        ));

        // Load view
        $this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/events/ics');
    }

    public function ical_month($year, $month)
    {
        // Load iCalendar helper
        $this->load->helper('ical_helper');

        // Timestamp of first of the month
        $first_day = mktime(0, 0, 0, $month, 1, $year);
        $last_day  = mktime(0, 0, 0, $month + 1, 0, $year);

        // Build dates to pass
        $range_start = date('Y-m-d', $first_day);
        $range_end   = date('Y-m-d', $last_day);

        // Get event data
        $events = $this->event->get_events($range_start, $range_end, null, true);

        // Pass header type
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: inline; filename=pdx-122-' . strtolower(date('M-Y', $first_day)) . '.ics');

        // Build calendar
        $output = ical_build_calendar($events, date('F Y', $first_day) . ' Active 20-30 Portland #122 Events Calendar');

        // Load output into view
        $this->load->vars(array(
            'output' => $output
        ));

        // Load view
        $this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/events/ics');
    }

    public function popup($p)
    {
        $output = $this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/events/popup/' . $p, null, true);
        $this->load->vars(
            array(
                'content' => $output,
                'title'   => 'Import iCalendar File Help'
            )
        );
        $this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/events/popup');
    }
}

/* End of file events.php */
/* Location: ./application/controllers/events.php */