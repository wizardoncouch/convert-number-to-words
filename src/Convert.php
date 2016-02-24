<?php
namespace ConvertNumberToWords;


class Convert{

    /**
     * return @string
     */
    public static function toWords($number = null, $wholeSuffix = 'point', $decimalSuffix = ''){
        if(!is_numeric($number)){
            throw new \InvalidArgumentException('Invalid number passed.');
        }

        $number = number_format($number,2,'.',','); //format the number passed

        $split = explode('.', $number); //split number from whole number and decimal

        $whole = self::convertWholeNumber($split[0]);
        $return = $whole;
        if($wholeSuffix != 'point'){
            $return .= ' ' . $wholeSuffix;
        }
        if(isset($split[1])){
            $decimal = self::convertDecimalNumber($split[1]);
            $return .= ' ' . $decimal;
            if(!empty($decimalSuffix)){
                $return .= ' ' . $decimalSuffix;
            }
        }

        return $return;
    }

    private static function convertWholeNumber($whole){
        if(abs($whole) > 0){

            $ones = self::setOnes();
            $tens = self::setTens();
            $hundreds = self::setHundreds();

            $wholeArray = array_reverse(explode(',',$whole));
            krsort($wholeArray);
            $returnText = '';
            foreach($wholeArray as $key => $i){
                if($i < 20){
                    $returnText .= $ones[$i];
                }
                elseif($i < 100){
                    $returnText .= $tens[substr($i,0,1)];
                    $returnText .= " ".$ones[substr($i,1,1)];
                }
                else{
                    $returnText .= $ones[substr($i,0,1)]." ".$hundreds[0];
                    $returnText .= " ".$tens[substr($i,1,1)];
                    $returnText .= " ".$ones[substr($i,2,1)];
                }
                if($key > 0){
                    $returnText .= " ".$hundreds[$key]." ";
                }

            }
            return $returnText;
        }

        return false;

    }

    private static function convertDecimalNumber($decimal){
        if($decimal > 0){
            $ones = self::setOnes();
            $tens = self::setTens();
            $returnText = '';
            if($decimal < 20){
                $returnText .= $ones[ltrim($decimal,'0')];
            }
            elseif($decimal < 100){
                $returnText .= $tens[substr($decimal,0,1)];
                $returnText .= " ".$ones[substr($decimal,1,1)];
            }
            return $returnText;
        }
    }

    /**
     * Define values for ones
     * return @array
     */
    private static function setOnes(){
        return array(
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen'
        );

    }

    /**
     * Define values for tens
     * return @array $tens
     */
    private static function setTens(){
        return array(
            0 => '',
            2 => 'Twenty',
            3 => 'Thirty',
            4 => 'Forty',
            5 => 'Fifty',
            6 => 'Sixty',
            7 => 'Seventy',
            8 => 'Eighty',
            9 => 'Ninety'
        );
    }

    /**
     * Define values for hundreds
     * return @array $hundreds
     */
    private static function setHundreds(){
        return array(
            'Hundred',
            'Thousand',
            'Million',
            'Billion',
            'Trillion',
            'Quadrillion'
        ); //TODO: I put a limit to quadrillion. You can go further if you like.
    }

}

echo Convert::toWords(124);

?>
