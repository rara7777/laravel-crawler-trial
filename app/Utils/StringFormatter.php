<?php

namespace App\Utils;

class StringFormatter
{
    static public function getTitle($body): string
    {
        $removedNewLineText = str_replace("\r\n",'',$body);
        if (preg_match('/true">(.*?)<\/title>/i', $removedNewLineText, $match) === 1 ||
            preg_match('/<title>(.*?)<\/title>/i', $removedNewLineText, $match) === 1
        ) {
            if(count($match)) {
                return $match[1];
            }
        }
        return '';
    }

    static public function getDescription($body)
    {
        $removedNewLineText = str_replace("\r\n",'',$body);
        if (preg_match('/description" content="(.*?)"/i', $removedNewLineText, $match) === 1) {
            if(count($match)) {
                return $match[1];
            }
        }
        return '';
    }

    static public function parseBody($body)
    {
        $removedNewLineText = str_replace("\r\n",'',$body);
        $text = preg_replace('/<style>(.*?)<\/style>/', '', $removedNewLineText);
        $text = preg_replace('/<style type="text\/css">(.*?)<\/style>/', '', $text);
        $text = preg_replace('/<svg(.*?)>(.*?)<\/svg>/', '', $removedNewLineText);
return strip_tags($text);
//        return $text;
    }
}
