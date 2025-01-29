<?php

namespace App\Token;


/** @package Token */
class Token
{
    public TokenType $type;
    public string $literal;

    public function __construct(TokenType $type = null, string $literal = null)
    {
        if (!($type && isset($literal))) {
            return;
        }
        $this->type = $type;
        $this->literal = $literal;
    }

    public function __tostring(): string
    {
        return "{TYPE: {$this->type->value}, LITERAL: $this->literal}\n";
    }
}

enum TokenType: string
{
    case ILLEGAL = "ILLEGAL";
    case EOF = "EOF";
    case EXPRESSION = "IDENT"; // Regular php

    // Delimiters;
    case LPAREN = "(";
    case RPAREN = ")";
    case ASSIGN = "{{";
    case ENDASSIGN = "}}";
    // Keywords;
    case OLD = "OLD";
    case IF = "IF";
    case ELSE = "ELSE";
    case FOREACH = "FOREACH";
    case AUTH = "AUTH";
    case ERRORS = "ERRORS";
    case ENDERRORS = "ENDERRORS";
    case ENDIF = "ENDIF";
    case ENDELSE = "ENDELSE";
    case ENDFOREACH = "ENDFOREACH";
    case ENDAUTH = "ENDAUTH";
}