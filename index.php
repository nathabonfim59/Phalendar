<?php
    /**
     * JS and CSS files to load in head
     */
    $resources = array(
        'css' => array(
            'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
            'css/styles.css'
        ),
        'js' => array(
            'https://code.jquery.com/jquery-3.2.1.min.js',
            'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
            'js/scripts.js'
        )
    );    

    /**
     * Insert all CSS and JS files into header
     *
     * @return string
     */
    function insert_resouces($resources) {
        foreach ($resources['css'] as $css) {
            echo '<link rel="stylesheet" href="'. $css .'">';
        }
        foreach ($resources['js'] as $js) {
            echo '<script src="'. $js .'"></script>';
        }
    }

    // Disable warning when switch is't provided
    error_reporting(1);

    $request_var = '?month=';

    $requested_month = $_REQUEST['month'];

    /**
     * Provide the name of the month and how much days it have
     * based in your number
     */
    switch($requested_month) {
        case 1: 
            $month_name = "January";
            $number_of_days = 31;
            break;
        case 2:
            $month_name = "February";
            $number_of_days = 28;            
            break;
        case 3:
            $month_name = "March";
            $number_of_days = 31;
            break;
        case 4:
            $month_name = "April";
            $number_of_days = 30;
            break;
        case 5:
            $month_name = "May";
            $number_of_days = 31;
            break;
        case 6:
            $month_name = "June";
            $number_of_days = 30;            
            break;
        case 7:
            $month_name = "July";
            $number_of_days = 31;
            break;
        case 8: 
            $month_name = "August";
            $number_of_days = 31;            
            break;
        case 9:
            $month_name = "Septempber";
            $number_of_days = 30;            
            break;
        case 10:
            $month_name = "October";
            $number_of_days = 31;            
            break;
        case 11:
            $month_name = "November";
            $number_of_days = 30;            
            break;
        case 12:
            $month_name = "December";
            $number_of_days = 30;            
            break;
        default:
            $month_name = "Invalid month";
            break;
    }


    /**
     * Returns a number of the previous month  in the pager
     *
     * @param [string] $direction 'next' or 'previous'
     * @param [integer] $requested_month 
     * @return string
     */
    function month_pager($direction, $requested_month) {
        if ($direction == 'next') {
            if ($requested_month == 12) {
                $month_to_go = 1;
            } else {
                $month_to_go = ($requested_month + 1);
            }
        } else {
            if ($requested_month == 1) {
                $month_to_go = 12;
            } else {
                $month_to_go = ($requested_month - 1);
            }
        }

        return '?month='.$month_to_go;
    }

    /**
     * Get the first day of a month in the following structure:
     * 
     * Sunday   -> 1
     * Monday   -> 2
     * ...
     * Friday   -> 6
     * Saturday -> 7
     *
     * @param [integer] $month
     * @return integer
     */
    function get_first_day($month) {
        $data = new DateTime('01-' . $month .'-'.date('Y'));
        $first_day = $data->format('D');
        switch($first_day) {
            case 'Sun':
                $initial_day_of_month = 1;
                break;
            case 'Mon':
                $initial_day_of_month = 2;
                break;
            case 'Tue':
                $initial_day_of_month = 3;
                break;
            case 'Wed':
                $initial_day_of_month = 4;
                break;
            case 'Thu':
                $initial_day_of_month = 5;
                break;
            case 'Fri':
                $initial_day_of_month = 6;
                break;
            case 'Sat':
                $initial_day_of_month = 7;
                break;
        }

        return $initial_day_of_month;
    }

    /**
     * Display a table with all days of month
     *
     * @param [integer] $month The number of month
     * @param [integer] $number_of_days The quantity of days in the month
     * @return void
     */
    function build_month_days($month, $number_of_days) {
        $days_of_month_html = '<tr class="week-day">';
        
        $days_in_week = 1;
        for ($days = 1; $days <= $number_of_days; $days++) {

            // Split the weeks in rows
            if ($days_in_week == 8) {
                $days_of_month_html = $days_of_month_html . '</tr>';
                $days_of_month_html = $days_of_month_html . '<tr class="week-day">';                
                $days_in_week = 1;
            }

            // Render days of week in the correct position
            if ($days == 1) {
                $initial_position = get_first_day($month);
                for($i = 1; $i < $initial_position; $i++) {
                    $days_of_month_html = $days_of_month_html . '<td class="day"></td>';
                    $days_in_week++;
                }
                if ($initial_position == 1) {
                    $days_of_month_html = $days_of_month_html . '<td class="day sunday">'.$days.'</td>';
                } else {
                    $days_of_month_html = $days_of_month_html . '<td class="day">'.$days.'</td>';
                }
            } else if ($days_in_week == 1) {
                $days_of_month_html = $days_of_month_html . '<td class="day sunday">'.$days.'</td>';
            } else {
                $days_of_month_html = $days_of_month_html . '<td class="day">'.$days.'</td>';                
            }

            $days_in_week++;
        }
        $days_of_month_html = $days_of_month_html . '</tr>';
        
        return $days_of_month_html;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calendar</title>
    <?php insert_resouces($resources); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="month">
            <p class="month-name"><?php echo $month_name; ?></p>
            <table class="month-table">
                <tr class="week-days">
                    <th class="week-day">Sun</th>
                    <th class="week-day">Mon</th>
                    <th class="week-day">Tue</th>
                    <th class="week-day">Wed</th>
                    <th class="week-day">Thu</th>
                    <th class="week-day">Fri</th>
                    <th class="week-day">Sat</th>
                </tr>
                <?php echo build_month_days($requested_month, $number_of_days); ?>
            </table>
        </div>
        
    </div>
    <nav aria-label="..." class="col-xs-12 text-center">
        <ul class="pager">
            <li><a href="<?php echo month_pager('previous', $requested_month); ?>">Previous</a></li>
            <li><a href="<?php echo month_pager('next', $requested_month); ?>">Next</a></li>
        </ul>
    </nav>
</body>
</html>