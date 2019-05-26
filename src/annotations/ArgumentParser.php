<?php


namespace annotations;


use php\lang\IllegalArgumentException;
use php\lib\char;
use php\lib\str;

class ArgumentParser{
    /**
     * @var int
     */
    private $pos;
    /**
     * @var int
     */
    private $len;
    /**
     * @var string
     */
    private $input;
    private $arguments = [];


    public function parse(string $input): array{
        $this->input = $input;
        $this->len = str::length($input);

        $this->pos = 0;
        $this->arguments = [];

        if(!$this->is('(') && $this->len == 0){
            return $this->arguments;
        }
        $this->skip('(');
        $this->skipWhitespaces();
        if($this->is(')')){
            return $this->arguments;
        }

        //$c = $this->current();
        while($this->pos < $this->len){
            $this->skipWhitespaces();
            $name = $this->readName();
            $this->skip('=');
            $this->arguments[$name] = $this->readValue();
            if(!$this->is(',')){
                break;
            }
            $this->next();
        }
        $this->skip(')');

        return $this->arguments;
    }
    private function readValue(){
        if($this->is('[')){
            return $this->readArray();
        }
        else if($this->is('_') || $this->isLetter()){
            return $this->readName(true);
        }
        else if($this->is('-') || $this->isDigit() || ($this->is('.') && $this->isDigit(1))){
            return $this->readNumber();
        }
        else if($this->is('\'') || $this->is('"')){
            return $this->readString();
        }
        else{
            throw new \RuntimeException("Unable to read something value");
        }
    }
    private function readNumber(){
        $number = '';

        $minus = $this->is('-');
        $c = $minus ? $this->next() : $this->current();
        while($this->pos < $this->len){
            if(!$this->is('.') && !$this->isDigit()){
                break;
            }
            $number .= $c;
            if($this->is('.') && str::contains($number, '.')){
                throw new \RuntimeException("Malformed number {$number}");
            }
            $c = $this->next();
        }
        if(str::startsWith($number, '.')){
            $number = '0'.$number;
        }
        else if(str::endsWith($number, '.')){
            $number = $number.'0';
        }

        $resultNumber = str::contains($number, '.') ? floatval($number) : intval($number);
        return $minus ? -$resultNumber : $resultNumber;
    }
    private function readString(): string{
        $start = $this->current();
        $isEscape = false;
        $string = "";
        $escapeMap = ['n' => "\n", 'r' => "\r", 't' => "\t"];

        $c = $this->next();
        while(isset($c)){
            if($c == '\\'){
                if($isEscape){
                    $string .= $c;
                    $isEscape = false;
                }
                else{
                    $isEscape = true;
                }
            }
            else if($c == "\n" && !$isEscape){
                throw new \RuntimeException("Unexpected end");
            }
            else if($c == $start && !$isEscape){
                $this->next();
                break;
            }
            else if($isEscape){
                $isEscape = false;

                if($escapeMap[$c]){
                    $string .= $escapeMap[$c];
                }
                else{
                    $string .= $c;
                }
            }
            else{
                $string .= $c;
            }

            $c = $this->next();
        }
        if($c != $start){
            throw new \RuntimeException("String not completed");
        }

        return $string;
    }
    private function readArray(){
        $this->skip('[');

        $result = [];
        $i = 0;

        while($this->pos < $this->len){
            $value = $this->readValue();
            if($this->is('=')){
                $this->next();
                $result[$value] = $this->readValue();
            }
            else{
                $result[$i++] = $value;
            }
            if($this->is(']') || !$this->is(',')){
                break;
            }
            $this->next();
        }
        $this->skip(']');

        return $result;
    }
    private function readName(bool $detectKeywords = false){
        $name = '';


        $c = $this->current();
        if(!$this->is('_') && !$this->isLetter()){
            throw new \Exception("Illegal argument name start");
        }
        while($this->pos < $this->len){
            if(!$this->is('_') && !$this->isDigit() && !$this->isLetter()){
                break;
            }
            $name .= $c;
            $c = $this->next();
        }
        if($detectKeywords){
            switch(str::lower($name)){
                case 'true':
                    return true;
                case 'false':
                    return false;
                case 'null':
                    return null;
            }
        }

        return $name;
    }
    private function skipWhitespaces(): void{
        while($this->is(' ', 0 , false) || $this->is("\n", 0, false)){
            $this->next();
        }
    }

    private function skip(string $c): void{
        $this->skipWhitespaces();
        if(!$this->is($c)){
            throw new \RuntimeException("Expected '{$c}', got '{$this->current()}'");
        }
        $this->next();
    }
    private function is(string $c, int $amount = 0, bool $skipWhiteSpaces = true): bool{
        if($skipWhiteSpaces){
            $this->skipWhitespaces();
        }
        return $this->peek($amount) == $c;
    }
    private function isLetter(int $amount = 0){
        return $this->inRange('a', 'z', $amount) || $this->inRange('A', 'Z', $amount);
    }
    private function isDigit(int $amount = 0){
        return $this->inRange('0', '9', $amount);
    }
    private function inRange(string $a, string $b, int $amount = 0){
        return ($ord = char::ord($this->peek($amount))) >= char::ord($a) && $ord <= char::ord($b);
    }

    private function peek(int $amount): ?string{
        $pos = $this->pos + $amount;
        if($pos < 0 || $pos >= $this->len){
            return null;
        }
        return $this->input[$pos];
    }
    private function current(): ?string{
        return $this->peek(0);
    }
    private function jump(int $amount): ?string{
        $this->pos += $amount;
        return $this->current();
    }
    private function next(): ?string{
        return $this->jump(1);
    }
}