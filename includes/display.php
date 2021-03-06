<?php
/**
 * Manage display  of the web interface (html mainly)
 * Date: 08/05/14
 * Time: 19:07
 */

function getLoginForm() {

    $error = "";
    if($_GET['error']) {
        $error = "<span style='color:red'>Bad Login</span>";
    }

    return '
    <div class="loginForm">
        <div class="loginTitle">Please log in :</div>
        <br />
        <form name="login" method="post" action="index.php" onkeyup="if(enter_pressed()) loginFormSubmit();">
        '.$error.'
        <table>
        <tr><td>Login :</td><td><input type="text" name="login"></td></tr>
        <tr><td>Password :</td><td><input type="password" name="password"></td></tr>
        <tr><td colspan="2">'.getButton("Login","#","onclick='loginFormSubmit();'").'</td></tr>
        </table>
        <input type="hidden" name="do" value="login_valid">
        </form>
        <br /><br />
    </div>';
}

function getButton ($text, $link="", $js="") {

    return '
    <a href="'.$link.'" '.$js.' class="css_btn_class">'.$text.'</a>';


}

function getDashBoard() {
	global $action_result;
	
    $hosts = getAllHosts();

    $return = '
    <div class="content">
        <div class="mainMenu">
            <ul>
                <li><a href="index.php?do=graphs">Graphs</a></li>
                <li><a href="index.php?do=hosts">Hosts</a></li>
                <li><a href="index.php?do=alerts">Alerts</a></li>
                <li><a href="index.php?do=settings">Settings</a></li>
                <li><a href="index.php?do=logout">Logout</a></li>
            </ul>
        </div>
        <div class="sideMenu">
            <h4>Hosts</h4>';
    if(!isset($_GET['do']) || in_array($_GET['do'],array("graphs","alerts","hosts"))) {
        foreach($hosts as $key=>$host) {
               $return .= '
               <a href="index.php?do='.$_GET['do'].'&host='.$host['host_id'].'">'.$host['host_name'].'</a><br />';
        }
    }

    $return .= '
        </div>
        <div class="mainContent">
            <h4 class="'.($_GET['do']?$_GET['do']:'graphs').'">'.ucfirst(($_GET['do']?$_GET['do']:'graphs')).'</h4>
			'.$action_result.'
            '.getDashBoardContent().'
        </div>
    </div>';

    return $return;
}

function getDashBoardContent() {

    $return = "";

    //which host to display ?
    if($_GET['host']) {
        $host = $_GET['host'];
    }
    else {
        $hosts = getAllHosts();
        $host = $hosts[0];
    }

    switch($_GET['do']) {
        case 'alerts':
            break;
        case 'hosts':
			$host_infos = getHostInfos($host);
			$return .= '<h1>'.$host_infos['infos']['host_name'].'</h1>';
			$return .= '<h2>Sensors :</h2>';
			if(count($host_infos['sensors'])) {

				$return .= '
				<table>
				<tr>
					<th>Name</th>
					<th>Type</th>
					<th>Value</th>
					<th>Max</th>
					<th>Actions</th>
				</tr>';

				foreach($host_infos['sensors'] as $key=>$sensor) {

                    $upLink = $downLink = "&nbsp;&nbsp;&nbsp;&nbsp;";
                    if($key>0) {
                        $upLink = '<a href="index.php?do=hosts&action=up&host='.$host['host_id'].'&sensor='.$sensor['sensor_id'].'">
                                    <img src="images/up.png">
                                   </a>';
                    }
                    if($key<count($host_infos['sensors'])-1) {
                        $downLink='<a href="index.php?do=hosts&action=down&host='.$host['host_id'].'&sensor='.$sensor['sensor_id'].'">
                                    <img src="images/down.png">
                                   </a>';
                    }




					$return .='
				<tr>
					<td>'.$sensor['sensor_name'].'</td>
					<td>'.$sensor['sensor_type'].'</td>
					<td>'.$sensor['sensor_value'].'</td>
					<td>'.($sensor['sensor_max']>0?$sensor['sensor_max']:'Auto').'</td>
					<td>
					    '.$upLink.'
					    '.$downLink.'
					    &nbsp;
					    <img src="images/edit.png">
					    &nbsp;
					    <img src="images/delete.png">
					</td>
				</tr>';

				}

				$return .= '
				</table>
				<br />';

			}
            else {
                $return.='<br>No sensors found for this host<br>';
            }
			$return .= '
			<br />
			<div class="add_sensor">
				<h6>Add a new sensor :</h6>
				<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
					<table width="300px">
					<tr>
						<td>Name :</td>
						<td><input type="text" name="name"></td>
					</tr>
					<tr>
						<td>Type :</td>
						<td><select name="type">'.getSensorTypesSelect().'</select></td>
					</tr>
					<tr>
						<td>OID :</td>
						<td><input type="text" name="value"></td>
					</tr>
					<tr>
						<td>Max value (0=auto) :</td>
						<td><input type="text" name="max" value="0"></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Add" ></td>
					</tr>
					</table>
					<input type="hidden" name="action" value="add_sensor">
					<input type="hidden" name="host_id" value="'.$host_infos['infos']['host_id'].'">
				</form>
			</div>
			';

            $return .= '
            <br />
			<div class="add_sensor">
				<h6>Add a new host :</h6>
				<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
					<table width="300px">
					<tr>
						<td>Name :</td>
						<td><input type="text" name="name"></td>
					</tr>
					<tr>
						<td>Description :</td>
						<td><input type="text" name="description"></td>
					</tr>
					<tr>
						<td>IP :</td>
						<td><input type="text" name="ip"></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Add" ></td>
					</tr>
					</table>
					<input type="hidden" name="action" value="add_host">
				</form>
			</div><br />
            ';
            

            break;
        case 'settings':
			$return .= '
			TODO<br>
			- Effacement des données les plus anciennes<br>
			- Créer des templates de sensors, pour ajout plus rapide sur les nouveaux hosts<br>
			- mettre à jour le fichier sql de install avec sensor_max et sensor_order<br>
            - enlever les valeurs de test dans poller_data<br>
            - faire marcher les boutons actions<br>
			-<br>
			-<br>';
            break;
        case 'graphs':
        default:
            if($_GET['range']) {
                $delay = (int)substr($_GET['range'],0,1);
                switch(substr($_GET['range'],-1)) {
                    case 'l':
                        $query = sql("SELECT MIN( log_date ) AS log_date
                                                FROM poller_data p
                                                JOIN hosts_sensors h ON ( h.sensor_id = p.sensor_id
                                                AND h.host_id =1 )");
                        $array = mysql_fetch_array($query);
                        $start = $array['log_date'];
                        break;
                    case 'h':
                        $start = date("Y-m-d H:i:s",mktime(date("H")-$delay,date("i"),date("s"),date("m"),date("d"),date("Y")));
                        break;
                    case 'd':
                    default:
                        $start = date("Y-m-d H:i:s",mktime(date("H"),date("i"),date("s"),date("m"),date("d")-$delay,date("Y")));
                        break;
                }
                $stop = date("Y-m-d H:i:s");
            }
            elseif($_POST['start'] && $_POST['stop']) {
                $start = $_POST['start'];
                $stop = $_POST['stop'];
            }
            else {
                $start = date("Y-m-d H:i:s",mktime(date("H"),date("i"),date("s"),date("m"),date("d")-2,date("Y")));
                $stop = date("Y-m-d H:i:s");
            }
            $host_infos = getHostInfos($host);
            $return .= '<h1>'.$host_infos['infos']['host_name'].'</h1>';
            //date selector
            $return .= '
            <div class="Selector">
            <ul class="rangeSelector">
                <li><a href="index.php?do=graphs&host='.$_GET['host'].'&range=8h">8h</a></li>
                <li><a href="index.php?do=graphs&host='.$_GET['host'].'&range=1d">1d</a></li>
                <li><a href="index.php?do=graphs&host='.$_GET['host'].'&range=3d">3d</a></li>
                <li><a href="index.php?do=graphs&host='.$_GET['host'].'&range=all">All</a></li>
            </ul>
            <ul class="dateSelector">
                <li>
                    <form method="post" action="index.php?do=graphs&host='.$_GET['host'].'">
                    From <input type="text" name="start" value="'.$start.'" size="14">
                    to <input type="text" name="stop" value="'.$stop.'" size="14">
                    <input type="submit" value="Update">
                    </form>
                </li>
            </ul>
            </div>';

            foreach($host_infos['sensors'] as $key=>$sensor) {
                $return .= '<div id="sensor'.$sensor['sensor_id'].'"></div><br />';
                $return .= getGraph($sensor['sensor_id'],$start,$stop,"sensor".$sensor['sensor_id'],$sensor['sensor_name']);
            }
            break;
    }

    return $return;
}

//return javascript code to draw a graph
function getGraph($sensor_id,$start,$stop,$div,$name) {

    //Get Data
    $query = sql("SELECT * FROM poller_data
    WHERE sensor_id='".$sensor_id."'
    AND log_date BETWEEN '".$start."' AND '".$stop."'
    ");
    $data = "";

    while($array = mysql_fetch_array($query)) {
        $data.="
[".strtotime($array['log_date'])."000, ".$array['value']."   ],";
    }


    //Get max value if defined
    $max_value = "";
    $query = sql("SELECT * FROM hosts_sensors
    WHERE sensor_id='".$sensor_id."'
    AND sensor_max>0");
    if(mysql_num_rows($query)) {
        $array = mysql_fetch_array($query);
        $max_value = "max: '".$array['sensor_max']."'";
    }

    $return .= "
    <script>
    $(function () {
        $('#".$div."').highcharts({
            global: {
                timezoneOffset: 600,
                useUTC: false
            },
            chart: {
                zoomType: 'x'
            },
            title: {
                text: '".$name."'
            },
            xAxis: {
                type: 'datetime',
            },
            yAxis: {
                title: {
                    text: '".$name."'
                },
                ".$max_value."
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: '#ACFA58',
                    lineWidth: 2,
                    threshold: null
                }
            },
            series: [{
                type: 'area',
                name: '".$name."',
                data: [
                    ".$data."
                ]
            }]
        });
    });
    </script>";


    return $return;


}

function getSensorTypesSelect() {
	$return = "";

	$query = sql("SELECT * FROM sensors");
	while($array=mysql_fetch_array($query)) {
		$return .= '
		<option>'.$array['sensor_type'].'</option>';
		
	}
	return $return;
}
