<?php
/**
 * データベースに英和辞典を突っ込む
 * 
 */
class InsertDictionary extends Executer
{
    /**
     * 偶数なの？ 
     *
     * @param integer $number 
     * @return bool
     */
    private function inspectEven($number)
    {
        $mod = $number % 2;
        if($mod === 0){
            return true;
        }elseif($mod !== 0){
            return false;
        }
    }
    public function executer($varNameArray, $sqlpre, $value)
    {
        $handle = fopen("gene-utf8.txt", "r");
        if ($handle){
            while (($buffer = fgets($handle)) !== false) {
                static $i = 1;
                static $j = 0;
                if ($this->inspectEven($i)) {
                    $transword = str_replace
                        (
                            array("\r\n", "\r", "\n"),
                            '',
                            $buffer
                        ); 
                    $sqlpre->execute(); 
                    $j++;
                    echo "{$j}行目インサート<br>";
                }else{
                    $enword = str_replace
                        (
                            array("\r\n", "\r", "\n"),
                            '',
                            $buffer
                        ); 
                }
                $i++;
            }
            fclose($handle);
            echo "インサート終了　行数".$j."行";
        }
    }
}
