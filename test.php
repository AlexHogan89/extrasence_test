<?
    //ini_set('error_reporting', E_ALL);
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    
    session_start();
    
    class ExtraSense {
        public $name = '';
        public $truth = 0;
        public $guess = 0;

        function set_name($name) {
        $this->name = $name;
        }
    }
    
    $extrasense1 = new ExtraSense();
    $extrasense2 = new ExtraSense();
    $extrasense3 = new ExtraSense();
    
    $extrasense1->set_name('Супер Олег');
    $extrasense2->set_name('Феофан');
    $extrasense3->set_name('Магистр Тьмы');
   
    $number = 0;
    if(isset($_POST["NumInput"])){
        $number = $_POST["NumInput"];
    }
    
    $NumHistory = array(array());
    $current = array();
    
    $TruthData = array(0,0,0);
    if(isset($_SESSION['truth_data'])){
        $TruthData = $_SESSION['truth_data'];
        $extrasense1->truth = $TruthData[0];
        $extrasense2->truth = $TruthData[1];
        $extrasense3->truth = $TruthData[2];
    }
    
    $GuessCounter = 0;
    if (isset($_SESSION['guess_counter']))
        {
            $GuessCounter = $_SESSION['guess_counter'];
        }
    else
    {
        $_SESSION['guess_counter'] = $GuessCounter;
    }
        
    $step = 0; // флаг шага: 0 - предложение загадать, 1 - вывод догадок
    if (isset($_SESSION['step']))
        {
            $step = $_SESSION['step'];
        }
    if (isset($_REQUEST['GuessButton'])){
        $_SESSION['step'] = $step++;    
    }


    function PercentOfLuck(ExtraSense $t){
    	global $GuessCounter;
        $d = round($t->truth*100/$GuessCounter, 1);;
        return $d;
    }

    function DrawGuessTable() {
        global $extrasense1;
        global $extrasense2;
        global $extrasense3;
        
        echo '<br>';
        echo "Догадки:";
        echo '<table border="1" cellpadding=10>';
        echo '<tr>'. '<td>'. $extrasense1->name . '</td>' . '<td>' . $extrasense1->guess  . '</td>' . '</tr>';
        echo '<tr>'. '<td>'. $extrasense2->name . '</td>' . '<td>' . $extrasense2->guess  . '</td>' . '</tr>';
        echo '<tr>'. '<td>'. $extrasense3->name . '</td>' . '<td>' . $extrasense3->guess  . '</td>' . '</tr>';
        echo '</table><br>';
    }

    function DrawTruthTable() {
        global $extrasense1;
        global $extrasense2;
        global $extrasense3;
        
        echo "Достоверность:";
        echo '<table border="1" cellpadding=10>';
        echo '<tr>'. '<td>'. $extrasense1->name . '</td>' . '<td>' . PercentOfLuck($extrasense1)  . "%" . '</td>' . '</tr>';
        echo '<tr>'. '<td>'. $extrasense2->name . '</td>' . '<td>' . PercentOfLuck($extrasense2)  . "%" . '</td>' . '</tr>';
        echo '<tr>'. '<td>'. $extrasense3->name . '</td>' . '<td>' . PercentOfLuck($extrasense3)  . "%" . '</td>' . '</tr>';
        echo '</table><br>';
    }
 
    function DrawHistoryTable() {
        global $extrasense1;
        global $extrasense2;
        global $extrasense3;
        
        echo "История:";
        echo '<table border="1" style="text-align:center;" cellpadding=10>';
        
        echo '<tr>'. '<td>'. "Загаданное число" . '</td>' . '<td>'. $extrasense1->name . '</td>' . '<td>'. $extrasense2->name . '</td>' . '<td>'. $extrasense3->name . '</td>' . '</tr>';
        
        
        foreach ($_SESSION['NumHistory'] as $item)
        {
    	    echo '<tr>'. '<td>'. $item[0]. '</td>' . '<td>'. $item[1]. '</td>' . '<td>'. $item[2]. '</td>' . '<td>'. $item[3] . '</td>' . '</tr>';
        }
        
        echo '</table><br>';
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <h3>Тестирование Экстрасенсов</h3>
    <h4>Загадайте число и узнайте какой экстрасенс лучше</h4>
    <br>
    
<?
 if($step == 0){
    echo '<h4>Загадайте число от 10 до 99</h4>';
    echo '<form method="POST"><input type="submit" name="GuessButton" value="Загадал"/></form><br>';
    
    if (isset($_SESSION['current'])){
        $current = $_SESSION['current'];
        $current[0] = $number;
        
        
        if($number == $current[1]) $extrasense1->truth++;
        if($number == $current[2]) $extrasense2->truth++;
        if($number == $current[3]) $extrasense3->truth++;
        
        $TruthData[0] = $extrasense1->truth;
        $TruthData[1] = $extrasense2->truth;
        $TruthData[2] = $extrasense3->truth;
        
        $_SESSION['truth_data'] = $TruthData;
        
        if(isset($_SESSION['NumHistory'])){
            $NumHistory = $_SESSION['NumHistory'];
            $NumHistory[] = $current;
        }
        else
        {
            $NumHistory[0] = $current;
        }
        $_SESSION['NumHistory'] = $NumHistory;
       // echo $GuessCounter;
        DrawTruthTable();
        DrawHistoryTable();
    }
 }
 
 if($step == 1){
    echo '<h4>Введите число которое загадали</h4>';
    echo '<form method="POST"><input maxlength="2" name="NumInput" size="2" type="number"/>';
    echo '<input type="submit" name="SendButton" value="Отправить"/></form><br>';
    
    $GuessCounter++;
    $_SESSION['guess_counter'] = $GuessCounter;
   // echo $GuessCounter;
    
    //$current = [0, $extra1, $extra2, $extra3];
    $_SESSION['current'] = [0, $extrasense1->guess = mt_rand(10,99), $extrasense2->guess = mt_rand(10,50), $extrasense3->guess = mt_rand(10,99)];
    
    DrawGuessTable();
 }
 
?>
</body>
</html>
