<?php
namespace HYKY\Validators;

/**
 * Services : HYKY\Validators\DocsBR
 * ----------------------------------------------------------------------
 * Provides helper static methods for Brazilian document validation and
 * formatting.
 *
 * @package     HYKY\Validators
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class DocsBR
{
    /**
     * Validates the Brazilian Legal Entity Registry (CNPJ) number.
     *
     * @param string $cnpj
     *      Number to check
     * @return boolean
     */
    public static function cnpjValidate(string $cnpj): bool
    {
        if ($cnpj === null || $cnpj === "") return false;
        
        // Sanitize string
        $cnpj = preg_replace("/\D/", "", $cnpj);
        
        // Check length
        if (strlen($cnpj) > 14) return false;
        if (strlen($cnpj) < 14) $cnpj = sprintf("%014s", $cnpj);
        
        // Check repetition
        for ($i = 0; $i < 10; $i++) {
            if (preg_match("/^{$i}{14}$/", $cnpj) !== 0) return false;
        }
        
        // Validate first digit
        $sum = 0;
        $val = 5;
        for ($n = 0; $n < 12; $n++) {
            $sum += ($cnpj[$n]) * $val;
            $val = ($val - 1 === 1) ? 9 : $val - 1;
        }
        $val = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);
        if ((int) $cnpj[12] !== $val) return false;
        
        // Validate second digit
        $sum = 0;
        $val = 6;
        for ($n = 0; $n < 13; $n++) {
            $sum += ($cnpj[$n]) * $val;
            $val = ($val - 1 === 1) ? 9 : $val - 1;
        }
        $val = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);
        if ((int) $cnpj[13] !== $val) return false;
        
        return true;
    }
    
    /**
     * Validates the Brazilian Natural Person Registry (CPF) number.
     *
     * @param string $cpf
     *      Number to check
     * @return boolean
     */
    public static function cpfValidate(string $cpf): bool
    {
        if ($cpf === null || $cpf === "") return false;
        
        // Sanitize string
        $cpf = preg_replace("/\D/", "", $cpf);
        
        // Check length
        if (strlen($cpf) > 11) return false;
        if (strlen($cpf) < 11) $cpf = sprintf("%011s", $cpf);
        
        // Check repetition
        for ($i = 0; $i < 10; $i++) {
            if (preg_match("/^{$i}{11}$/", $cpf) !== 0) return false;
        }
        
        // Validate first digit
        $sum = 0;
        for ($n = 0; $n < 9; $n++) $sum += $cpf[$n] * (10 - $n);
        $val = 11 - ($sum % 11);
        if ($val === 10 || $val === 11) $val = 0;
        if ((int) $cpf[9] !== $val) return false;
        
        // Validate second digit
        $sum = 0;
        for ($n = 0; $n < 10; $n++) $sum += $cpf[$n] * (11 - $n);
        $val = 11 - ($sum % 11);
        if ($val === 10 || $val === 11) $val = 0;
        if ((int) $cpf[10] !== $val) return false;
        
        return true;
    }
}
