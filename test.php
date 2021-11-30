<?
    session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  
  <h3>Тестирование Экстрасенсов</h3>

<h4>Загадайте число от 0 до 10 и узнайте какой экстрасенс лучше</h4>

<form method="POST">
    <input maxlength="3" name="NumInput" size="3" type="number" />
	<input type="submit" name="SendButton" value="Отправить экстрасенсам"/>
</form>

<br>
<?
    class ExtraSense {
        public $name;
        public $truth;

        function set_name($name) {
        $this->name = $name;
        }
        
        function set_truth($truth) {
        $this->truth = $truth;
        }
        
        function get_name() {
        return $this->name;
        }
        
        function get_truth() {
        return $this->truth;
        }
    }
    
    $extrasense1 = new ExtraSense();
    $extrasense2 = new ExtraSense();
    $extrasense3 = new ExtraSense();
    
    $extrasense1->set_name('Супер Олег');
    $extrasense2->set_name('Феофан');
    $extrasense3->set_name('Магистр Тьмы');
   
    $number = 0;
    $full = array(array());
    $current = array();
    //$truth_of_extra1 = 0;
    //$truth_of_extra2 = 0;
    //$truth_of_extra3 = 0;
    $counter = 0;
    
    function PercentOfLuck(ExtraSense $t){
    	global $counter;
        $d = round($t->truth*100/$counter, 1);;
        return $d;
    }
   
    function Debug() {
        echo $truth_of_extra1 . '<br>' . $truth_of_extra2 . '<br>' . $truth_of_extra3 . '<br>' . $counter . '<br>'; //вывод счетчиков
    }
    
    function DrawTrouthTable() {
        global $extrasense1;
        global $extrasense2;
        global $extrasense3;
        
        echo "Достоверность:";
        echo '<table border="1" cellpadding=10>';
        echo '<tr>'. '<td>'. $extrasense1->name . '</td>' . '<td>' . PercentOfLuck($extrasense1)  . "%" . '</td>' . '</tr>';
        echo '<tr>'. '<td>'. $extrasense2->name . '</td>' . '<td>' . PercentOfLuck($extrasense2)  . "%" . '</td>' . '</tr>';
        echo '<tr>'. '<td>'. $extrasense3->name . '</td>' . '<td>' . PercentOfLuck($extrasense3)  . "%" . '</td>' . '</tr>';
        echo '</table>';
    }
 
    function DrawHistoryTable() {
        global $extrasense1;
        global $extrasense2;
        global $extrasense3;
        
        echo "История:";
        echo '<table border="1" style="text-align:center;" cellpadding=10>';
        
        echo '<tr>'. '<td>'. "Загаданное число" . '</td>' . '<td>'. $extrasense1->name . '</td>' . '<td>'. $extrasense2->name . '</td>' . '<td>'. $extrasense3->name . '</td>' . '</tr>';
        
        
        foreach ($_SESSION['full'] as $item)
        {
    	    echo '<tr>'. '<td>'. $item[0]. '</td>' . '<td>'. $item[1]. '</td>' . '<td>'. $item[2]. '</td>' . '<td>'. $item[3] . '</td>' . '</tr>';
        }
        
        echo '</table>';
    }
    
    if (isset($_SESSION['counter']))
        {
            $counter = $_SESSION['counter'];
        }
    else
        {
             $counter = 0;
             $_SESSION['counter'] = $counter;
        }
    
    if(isset($_POST["NumInput"])){
        $number = $_POST["NumInput"];
    }
    
    if (isset($_REQUEST['SendButton']))
    {
        $extra1 = rand(0,10);
        $extra2 = rand(0,10);
        $extra3 = rand(0,10);
        
       
        $counter++;
        $_SESSION['counter'] = $counter;
        
        if (isset($_SESSION['truth_of_extra1']))
        {
            $extrasense1->truth = $_SESSION['truth_of_extra1'];
        }
        else
        {
            $extrasense1->truth = 0;
            $_SESSION['truth_of_extra1'] = $extrasense1->truth;
        }
        
        if (isset($_SESSION['truth_of_extra2']))
        {
            $extrasense2->truth = $_SESSION['truth_of_extra2'];
        }
        else
        {
            $extrasense2->truth = 0;
            $_SESSION['truth_of_extra2'] = $extrasense2->truth;
        }
        
        if (isset($_SESSION['truth_of_extra3']))
        {
            $extrasense3->truth = $_SESSION['truth_of_extra3'];
        }
        else
        {
            $extrasense3->truth = 0;
            $_SESSION['truth_of_extra3'] = $extrasense3->truth;
        }
        
        $full = $_SESSION['full'];
        
        if($number == $extra1) $extrasense1->truth++;
        if($number == $extra2) $extrasense2->truth++;
        if($number == $extra3) $extrasense3->truth++;
        
        $_SESSION['truth_of_extra1'] = $extrasense1->truth;
        $_SESSION['truth_of_extra2'] = $extrasense2->truth;
        $_SESSION['truth_of_extra3'] = $extrasense3->truth;
        
        $current = [$number, $extra1, $extra2, $extra3];
        $full[] = $current;
        
        $_SESSION['full'] = $full;
        
        //Debug();
        if($counter > 0) {
            DrawTrouthTable();
        }
        
        echo '<br>';
        DrawHistoryTable();
    /*    echo "История:";
        echo '<table border="1" style="text-align:center;" cellpadding=10>';
        
        echo '<tr>'. '<td>'. "Загаданное число" . '</td>' . '<td>'. "Экстрасенс Влад" . '</td>' . '<td>'. "Экстрасенс Олег" . '</td>' . '<td>'. "Экстрасенс Афдотья" . '</td>' . '</tr>';
        
        
        foreach ($_SESSION['full'] as $item)
        {
    	    echo '<tr>'. '<td>'. $item[0]. '</td>' . '<td>'. $item[1]. '</td>' . '<td>'. $item[2]. '</td>' . '<td>'. $item[3] . '</td>' . '</tr>';
        }
        
        echo '</table>'; */

    }
    
    
    
?>

</body>
</html>
