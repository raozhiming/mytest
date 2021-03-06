<?php

$allCountries = require("./countryZone.php");

class Utils {

    public static function sortArrayByOneField($data, $field, $desc = false) {
        $fieldArr = array();
        foreach ($data as $key => $value) {
            $fieldArr[$key] = $value[$field];
        }
        $sort = $desc == false ? SORT_ASC:SORT_DESC;
        array_multisort($fieldArr, $sort, $data);
    }

    public static function writeArray2csv($filename, $column_names, $limit_count, $data)
    {
        if (empty($data)) {
            printf("data error\r\n");
            print_r($data);
            return;
        }

        $fp = fopen($filename, 'w+b');
        $utf8BOM = "\xEF\xBB\xBF";
        fwrite($fp, $utf8BOM);
        $column = implode(",", $column_names);
        fwrite($fp, $column."\r\n");
        $multiArray = false;

        if (count($column_names) > 2) $multiArray = true;

        $cal_count = 0;
        $otherValue = 0;
        $otherArray = array();

        foreach ($data as $key => $value) {
            if ($multiArray) {
                $values = array_values($value);
                $writeString = implode(",", $values)."\r\n";
            }
            else {
                $writeString = $key.",".$value."\r\n";
            }
            fwrite($fp, $writeString);
        }
    }

    public static function calTotalValue($data, $index, $column) {
        $data[0][$column] = $data[0][$index];
        for ($i = 1; $i < sizeof($data); $i++) {
            $data[$i][$column] = $data[$i - 1][$column] + $data[$i][$index];
        }

        return $data;
    }


    public static function calTop($data, $top, $column) {
        $newArray = array();
        $otherArray = array();

        $values = array_values($column);
        $otherArray[$values[0]] = 'Others';

        for ($i = 0; $i < sizeof($data); $i++) {
            if ($i < $top) {
                $newArray[] = $data[$i];
            }
            else {
                for ($j = 1; $j < sizeof($column); $j++) {
                    $otherArray[$values[$j]] += $data[$i][$values[$j]];
                }
            }
        }
        $newArray[] = $otherArray;
        return $newArray;
    }

    public static function addCountryName($data) {
        global $allCountries;

        foreach ($data as $key => $value) {
            $data[$key]['CountryName'] = $allCountries[$value['zone']];
        }
        return $data;
    }
}

?>