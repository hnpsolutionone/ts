<?php
/**
 * Implement for Unit Test.
 */
require_once 'TS.class.php';

class TSTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers TS::compute
     * @todo   Implement testTS().
     */
    public function testTS()
    {
        $ts_test = new TS;
        $ts_test->add(1, 'Beijing AAA', 39.93, 116.40);
        $ts_test->add(2, 'Tokyo', 35.40, 139.45);
        $ts_test->add(3, 'Vladivostok', 43.8, 131.54);
        $ts_test->add(4, 'Dakar', 14.40, -17.28);
        $ts_test->add(5, 'Singapore', 1.14, 103.55);
        $ts_test->initMatrix();
        // calculator begin with Beijing city.
        $ts_test->compute(count($ts_test->locations), 1, $ts_test->cost_matrix);
        $this->assertNotNull($ts_test->cost);
    }
}

?>