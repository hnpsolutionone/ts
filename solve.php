<?php
/* PHP Class TS

Author: 	Phuong Nguyen
Description:
	Class TS is a calculator for the common "Travel Man" base on Nearest Neighbor Algorithm (O(n2)).

Date: 		2017-05-20

*/

class TS {

    public $locations 	= array();		// all locations to visit
	public $cost_matrix = array();      // all cost between cities
    public $visited = array();          // the shortest route
    public $cost = null;                // the distance route
    private $infinity = 10000;          // define the Infinity number

	// add a location
    public function add($i,$name,$longitude,$latitude){
        $this->locations[$i] = array('name'=>$name,'longitude'=>$longitude,'latitude'=>$latitude);
    }

    // stored information from file into $locations array
    public function store_matrix($file_name){
        if ($file = fopen($file_name, "r")) {
            $i = 1;
            while(!feof($file)) {
                $line = fgets($file);
                $address = explode(" ", trim($line));
                if(count($address) == 3) {
                    $this->add($i, $address[0], $address[1], $address[2]);
                }
                elseif(count($address) == 4){
                    $this->add($i, $address[0] . ' ' . $address[1], $address[2], $address[3]);
                }
                $i++;
            }
            fclose($file);
        }
    }

    // init the cost matrix moves between cities
    public function init_matrix(){
        $num_locations = count($this->locations);
        for ($i = 1; $i <= $num_locations; $i++) {
            for ($j = 1; $j <= $num_locations; $j++) {
                if($i == $j) {
                    $this->cost_matrix[$i][$j] = $this->infinity;
                }else{
                    $this->cost_matrix[$i][$j] = $this->distance($this->locations[$i]['latitude'],$this->locations[$i]['longitude'],$this->locations[$j]['latitude'],$this->locations[$j]['longitude']);
                }
            }
        }
    }

    // show the all cities which have visited
    public function print_route(){
        foreach(end($this->visited) as $visit) {
            print $this->locations[$visit]['name'] . '<br />' ;
        }
    }

    // calculator base on Nearest neighbor algorithm.
    public function compute($n, $v, $mt_cities){
        for($i = 0; $i <= $n; $i++)
            $flag[$i]=0;

        $t=$v;
        $count=0;
        $tour[$t][0]=$v;
        $cost=0;
        $flag[$v]=1;
        $tmp=$v;

        while($count != $n-1)
        {
            $tmp_cost = $this->infinity;
            for($i = 1; $i <= $n; $i++)
            {
               if($tmp_cost > $mt_cities[$v][$i] && $flag[$i]==0 && $mt_cities[$v][$i] != -1)
               {
                   $tmp_cost = $mt_cities[$v][$i];
                   $yes = $i;
               }
            }
            $count++;
            $tour[$t][$count] = $yes;
            $cost += $tmp_cost;
            $flag[$v] = 1;
            $v = $yes;
        }
        $cost += $mt_cities[$v][$tmp];
        $this->visited = $tour;
        $this->cost = $cost;
    }

	// work out the distance between 2 longitude and latitude pairs
	function distance($lat1, $lon1, $lat2, $lon2) {
		if ($lat1 == $lat2 && $lon1 == $lon2) return 0;
		$unit = 'M';	// miles please!
		$theta = $lon1 - $lon2; 
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
		$dist = acos($dist); 
		$dist = rad2deg($dist); 
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
			return ($miles * 1.609344); 
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
	}
}

$ts = new TS;

// open file cities.txt and stored information of file into array
$ts->store_matrix('cities.txt');
// init the cost matrix moves between cities.
$ts->init_matrix();
// calculator to find shortest route base on Nearest neighbor algorithm and begin with Beijing (=1) city .
$ts->compute(count($ts->locations), 1 ,$ts->cost_matrix);
// print the result shortest distance and shortest route
print '<strong>Shortest Distance</strong>: ' . $ts->cost;
print '<br /><strong>Shortest Route</strong>: <br />';
$ts->print_route();
?>