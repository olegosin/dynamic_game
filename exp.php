

        <?php
      
        ini_set('display_errors', 1);
        ini_set('log_errors', 1);
        ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	error_reporting(E_ALL);

	// read dbcfg file for url/username/password
		
	$dbcfg = fopen("dbcfg.cfg", 'r');
	$host = trim(fgets($dbcfg));
	$user = trim(fgets($dbcfg));
	$pw = trim(fgets($dbcfg));
	fclose($dbcfg);
		mysql_connect($host, $user, $pw) or die(mysql_error());
		mysql_select_db("dynamic_pong") or die(mysql_error());
		
		//mysql_connect("127.0.0.1", "oleg", "") or die(mysql_error());
		//mysql_select_db("test") or die(mysql_error());
		
		
		function createInputProperty($inputPropertyName, $outputPropertyName, $weight, $value = null)
		{	
			$res = mysql_query("SELECT * FROM input_properties
			WHERE inputName='$inputPropertyName' and outputName='$outputPropertyName'")
			or die(mysql_error());
			
			$jsonStr = json_encode('success');
			print $jsonStr;
			
			$res = mysql_fetch_array($res);

			if($res)
				return;
				
			//var_dump($res);
			mysql_query("INSERT INTO input_properties
			(inputName, outputName, weight, value) VALUES('$inputPropertyName', '$outputPropertyName' , '$weight', '$value') ") 
			or die(mysql_error());  
		}
		
		function setInputProperty($inputPropertyName, $value)
		{
			$value = floatval($value);
			mysql_query("UPDATE input_properties
			SET value='$value' WHERE inputName='$inputPropertyName'")
			or die(mysql_error());
			
			$jsonStr = json_encode('success');
			print $jsonStr;
		}
		
		function getOutputProperty($outputPropertyName)
		{
			$res = mysql_query("SELECT * FROM input_properties
			WHERE outputName='$outputPropertyName'")
			or die(mysql_error());

			//$res = mysql_fetch_array($res);
			//var_dump("=== called get prop ===" . $outputPropertyName);
			$d = mysql_fetch_row($res);
			
			/*foreach($res as $row)
			{
				var_dump($row);
				var_dump("----");
			}*/
			/*var_dump($d[1]); // input prop name
			var_dump($d[2]); // output prop name
			var_dump($d[3]); // weight
			var_dump($d[4]); // value
			*/
			$weight = floatval($d[3]);
			$finalValue = $weight * floatval($d[4]);

			$arr = array("output_property" => $d[2], "value" => $finalValue);
			//var_dump($finalValue);
			$jsonStr = json_encode($arr);
			print $jsonStr;
		}

		function getAllProperties()
		{
			$res = mysql_query("SELECT * FROM input_properties") or die(mysql_error());
			$rows = mysql_fetch_row($res);
			return $rows;	
		}

		/*
        	createInputProperty("olewg", "out", 3.2);
        	createInputProperty("otherpr", "out", 2.2);
        	createInputProperty("dd", "out2", 2.2, 13);
		setInputProperty("olewg", 2.9);
		setInputProperty("otherpr", 5.0);
		getOutputProperty("out");
		*/
		if(isset($_GET['game_api']))
		{
			switch($_GET['game_api'])
			{
				case 'get_all_properties':
				{
					getAllProperties();
				}
				break;
				
				case 'get_output_property':
				{
					$outputProp = $_GET['p_out_name'];
					getOutPutProperty($outputProp);
				}
				break;
				
				case 'set_input_property':
				{
					$inputProp = $_GET['p_input_name'];
					$value = $_GET['p_value'];
					setInputProperty($inputProp, $value);
				}
				break;
				
				case 'create_input_property':
				{
					$inputProp = $_GET['p_input_property'];
					$outProp = $_GET['p_output_property'];
					$weight = $_GET['p_weight'];
					$value = null;
					if(isset($_GET['p_value']))
						$value = $_GET['p_value'];
						
					createInputProperty($inputProp, $outProp, $weight, $value);
				}
				break;
				
				default:
				{
					var_dump('game api function does not exist');
				}
				break;
			}
		}

// Create a MySQL table in the selected database
/*mysql_query("CREATE TABLE input_properties(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
 name VARCHAR(30),
 value INT,
 weight INT)")
 or die(mysql_error());
*/
/*
 mysql_query("INSERT INTO input_properties 
(name, value, weight) VALUES('GameTime', '23', '0.2' ) ") 
or die(mysql_error());  

 
echo "Table Created!";
*/


//$d = array('s'=>'1', 'd'=>'3', 'f'=>'32');
//$jsonStr = json_encode($d);
			//print $jsonStr;
mysql_close();
/*
        //include("./defines.php");
        include("./question_manager.php");


        //if(isset($_POST['answer_pressed']) === false)
        //srand(time());

        // generate question list
        $questionMan = QuestionManager::getInstance();
        

        //print_r($questionMan);
        echo"<br><br>------<br>";
        print_r($questionMan->getQuestionList());
        echo"<br>------<br>";

        // draw to screen
        $html_question = $questionMan->getNextQuestion();
        echo "<br>Please answer the following question: $html_question<br>";
*/
        ?>
