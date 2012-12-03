<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(Kohana::find_file('vendor/phpmorphy-0.3.7/src', 'common'));

class Kohana_PHPMorphy_TokenFilter extends Zend_Search_Lucene_Analysis_TokenFilter {

    protected $morphy;

    public function __construct()
    {
        $config  = Kohana::$config->load('phpmorphy');
        $dir     = $config->get('dir');
        $lang    = $config->get('lang');
        $options = $config->get('options');
        try
        {
            $this->morphy = new phpMorphy($dir, $lang, $options);
        }
        catch (phpMorphy_Exception $e)
        {
            die('Error occured while creating phpMorphy instance: ' . $e->getMessage());
        }
    }

    public function normalize(Zend_Search_Lucene_Analysis_Token $srcToken)
    {

        $pseudoRoot = $this->morphy->getPseudoRoot(mb_strtoupper($srcToken->getTermText(), 'utf-8'));

        if ($pseudoRoot === FALSE)
        {
            $newStr = mb_strtoupper($srcToken->getTermText(), 'utf-8');
        }
        else
        {
            $newStr = $pseudoRoot[0];
        }

        if (mb_strlen($newStr, 'utf-8') < 2)
        {
            return NULL;
        }

        $newToken = new Zend_Search_Lucene_Analysis_Token(
                $newStr, $srcToken->getStartOffset(), $srcToken->getEndOffset()
        );

        $newToken->setPositionIncrement($srcToken->getPositionIncrement());

        return $newToken;
    }

}