<?php
$query = 
'INSERT INTO tedword.cannot_translation_words
(cannottransword) VALUES(:cannottransword)';
/**
 * 翻訳できなかった（リザルトを得られなかった）単語の履歴収集
 */
class CanNotTranslation extends InsertExecuter
{
    public function executer($query)
    {
        
    }
}


