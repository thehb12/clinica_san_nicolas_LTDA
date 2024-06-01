<?php

namespace App\Services\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\QueryException;

/**
 * @author Andrew Mackrodt <andrew@ajmm.org>
 */
class IfNull extends FunctionNode
{
    private $expr1;

    private $expr2;

    /**
     * @throws QueryException
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->expr1 = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->expr2 = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker): string
    {
        return 'IFNULL('
            .$sqlWalker->walkArithmeticPrimary($this->expr1). ', '
            .$sqlWalker->walkArithmeticPrimary($this->expr2).')';
    }
}
