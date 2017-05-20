# ts
Class TS is a calculator for the common "Travel SaleMan" base on Nearest Neighbor Algorithm (O(n2)).

1. For Site: 
- You navigation to URL http://[your_domain]/solve.php
- Note: run "php solve.php" in your command prompt to show text with new line (\n)

2. For Unit Test (required PHPUnit 3.7.21 by Sebastian Bergmann):

- You naviagtion to your folder which include the code in your command prompt
- Run command line: "phpunit unit_test.php"

3. Performance testing with Gatling tool

- I have run 10 requests to 50 requests. The results performance very good (under 1s/request). You can open two files below and review them:
+ \results\Performance Testing with Gatling\10 requests in duration 22 seconds\index.html
+ \results\Performance Testing with Gatling\50 requests in duration 102 seconds\index.html
