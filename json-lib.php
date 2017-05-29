<?php
    function getJsonLine($jsonIn, $indentCount = 1)
    {
        $jsonOut = '';

        $indentString = '    ';
        $newLineChar = "\n";

        if (is_array($jsonIn)) {
            $firstIteration = true;

            foreach ($jsonIn as $key => $value) {
                $valueOutWithQuotes = false;

                if (!$firstIteration) {
                    $jsonOut .= ',' . $newLineChar;
                }

                if (is_array($value)) {
                    $newIndentCount = $indentCount + 1;
                    $value = getJsonLine($value, $newIndentCount);
                } elseif (is_null($value)) {
                    $value = 'null';
                } elseif ($value === true) {
                    $value = 'true';
                } elseif ($value === false) {
                    $value = 'false';
                } elseif (!is_numeric($value)) {
                    //  This is a string value so use quotes
                    $valueOutWithQuotes = true;
                }

                $indent = str_repeat($indentString, $indentCount);
                $jsonOut .= $indent . sprintf(($valueOutWithQuotes ? '"%s": "%s"' : '"%s": %s'), $key, $value);

                $firstIteration = false;
            }
        }

        $nextLineIndent = str_repeat($indentString, $indentCount - 1);
        return '{' . $newLineChar . $jsonOut . $newLineChar . $nextLineIndent . '}';
    }

    function getFormattedJson($jsonIn)
    {
        return getJsonLine($jsonIn);
    }

    function getUnformattedJson($jsonIn)
    {
        //  Just encode the value again and let PHP deal with it
        return json_encode($jsonIn);
    }
