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

    /**
     * Add a location
     *
     * @param int $i The position of city
     * @param string $name The city name
     * @param int $longitude The longitude of city
     * @param int $latitude The latitude of city
     */
    public function add($i,$name,$longitude,$latitude)
    {
        $this->locations[$i] = array('name'=>$name, 'longitude'=>$longitude, 'latitude'=>$latitude);
    }

    /**
     * Stored information from file into locations array
     *
     * @param File $file_name A cities text
     */
    public function storeMatrix($file_name)
    {
        if ($file = fopen($file_name, "r")) {
            $i = 1;
            while(!feof($file)) {
                $line = fgets($file);
                $address = explode(" ", trim($line));
                if (count($address) == 3) {
                    $this->add($i, $address[0], $address[1], $address[2]);
                } elseif (count($address) == 4){
                    $this->add($i, $address[0] . ' ' . $address[1], $address[2], $address[3]);
                }
                $i++;
            }
            fclose($file);
        }
    }

    /**
     * Init the cost matrix moves between cities
     */
    public function initMatrix()
    {
        $num_locations = count($this->locations);
        for ($i = 1; $i <= $num_locations; $i++) {
            for ($j = 1; $j <= $num_locations; $j++) {
                if ($i == $j) {
                    $this->cost_matrix[$i][$j] = $this->infinity;
                } else {
                    $this->cost_matrix[$i][$j] = $this->distance($this->locations[$i]['latitude'], $this->locations[$i]['longitude'], $this->locations[$j]['latitude'], $this->locations[$j]['longitude']);
                }
            }
        }
    }

    /**
     * Show the all cities which have visited
     */
    public function printRoute()
    {
        foreach (end($this->visited) as $visit) {
            echo $this->locations[$visit]['name'] . "\n" ;
        }
    }

    /**
     * Calculator base on Nearest Neighbor Algorithm.
     *
     * @param int $n The total of cities
     * @param int $v The start point of tour
     * @param int $mt_cities The matrix include all cost between cities
     */
    public function compute($n, $v, $mt_cities)
    {
        for ($i = 0; $i <= $n; $i++)
            $flag[$i] = 0;

        $t = $v;
        $count = 0;
        $tour[$t][0] = $v;
        $cost = 0;
        $flag[$v] = 1;
        $tmp = $v;

        while ($count != $n-1)
        {
            $tmp_cost = $this->infinity;
            for ($i = 1; $i <= $n; $i++)
            {
                if ($tmp_cost > $mt_cities[$v][$i] && $flag[$i] == 0 && $mt_cities[$v][$i] != -1)
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

    /**
     * Work out the distance between 2 longitude and latitude pairs
     *
     * @param int $lat1 The latitude of City 1
     * @param int $lon1 The longitude of City 1
     * @param int $lat2 The latitude of City 2
     * @param int $lon2 The longitude of City 2
     */
    function distance($lat1, $lon1, $lat2, $lon2)
    {
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

?>