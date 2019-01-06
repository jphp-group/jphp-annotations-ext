<?php


namespace annotations;


use php\lib\str;
use phpx\parser\SourceToken;
use phpx\parser\SourceTokenizer;

class UsagesParser{
    /**
     * @var array
     */
    protected $usages = [];
    /**
     * @var array
     */
    protected $usagesAliases = [];

    /**
     * @var boolean
     */
    protected $useStatementsParsed = false;

    /**
     * @var SourceTokenizer
     */
    private $tokenizer;

    /**
     * @var string
     */
    private $source;

    /**
     * UsagesParser constructor.
     * @param string $source
     */
    public function __construct(string $source){
        $this->source = $source;
    }


    public function parse(): void {
        if($this->useStatementsParsed){
            return;
        }
        $this->tokenizeSource();
        $this->useStatementsParsed = true;
    }

    private function tokenizeSource(): void {
        $this->tokenizer = new SourceTokenizer($this->source, '', 'UTF-8');

        //$namespace = '';
        while($token = $this->nextToken()){
            if($token->type == 'ClassStmt' || $token->type == 'InterfaceStmt' || $token->type == 'TraitStmt'){
                while($token = $this->nextToken()){
                    if($token->type == 'BraceExpr'){
                        break;
                    }
                }
                $depth = 1;
                while($token = $this->nextToken()){
                    if($token->type == 'BraceExpr'){
                        $depth += $token->word == '}' ? -1 : 1;
                    }
                    if($depth == 0){
                        break;
                    }
                }
                if(!$token){
                    break;
                }
            }
            if($token->type == 'NamespaceStmt'){
                //$namespace = $this->nextToken()->word; // skip namespace name
                $this->nextToken(); // skip semicolon
            }
            elseif($token->type == 'NamespaceUseStmt'){
                $useName = $this->nextToken()->word;
                $nextToken = $this->nextToken();
                if($nextToken->type == 'BraceExpr'){
                    while($token = $this->nextToken()){
                        if($token->type == 'Comma'){
                            continue;
                        }
                        if($token->type == 'BraceExpr'){
                            break;
                        }
                        $this->store($useName.$token->word);
                    }
                }
                else if($nextToken->type == 'AsStmt'){
                    $token = $this->nextToken();
                    $this->storeAlias($token->word, $useName);
                }
                else{
                    $this->store($useName);
                }
                //$this->nextToken();
            }
        }
        $this->tokenizer->close();

//        $this->usages = $useStatements;
//        $this->usagesAliases = $asStatements;
    }

    private function store(string $usage): void{
        $this->usages[$this->getSimpleClassName($usage)] = $usage;
    }
    private function storeAlias(string $alias, $class): void{
        $this->usagesAliases[$alias] = $class;
    }

    private function getSimpleClassName(string $class): string{
        return ($i = str::lastPos($class, '\\')) == -1 ?  $class : str::sub($class, $i + 1);
    }

    private function nextToken() : ?SourceToken{
        $token = $this->tokenizer->next();
        if(!$token){
            return null;
        }
        while($token->type == 'Comment'){
            $token = $this->nextToken();
        }
        return $token;
    }

    /**
     * @return array
     */
    public function getUsages() : array{
        return $this->usages;
    }
    /**
     * @return array
     */
    public function getUsagesAliases() : array{
        return $this->usagesAliases;
    }


    public function getName(string $alias): string{
        if(isset($this->usages[$alias])){
            return $this->usages[$alias];
        }
        if(isset($this->usagesAliases[$alias])){
            return $this->usagesAliases[$alias];
        }
        return $alias;
    }
    public function getReflection(string $alias): ?\ReflectionClass{
        try{
            return new \ReflectionClass($this->getName($alias));
        }
        catch(\ReflectionException $e){
            return null;
        }
    }
}