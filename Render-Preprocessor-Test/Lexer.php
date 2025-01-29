<?php

namespace App\Lexer;

use App\Token\Token;
use App\Token\TokenType;

class Lexer
{
    private string $input;
    private int $position;
    private int $read_position;
    private string $ch;

    /** @var array<string, TokenType> KEYWORDS  */
    const KEYWORDS = [
        "if" => TokenType::IF ,
        "endif" => TokenType::ENDIF ,
        "else" => TokenType::ELSE ,
        "endelse" => TokenType::ENDELSE,
        "foreach" => TokenType::FOREACH ,
        "endforeach" => TokenType::ENDFOREACH ,
        "auth" => TokenType::AUTH,
        "endauth" => TokenType::ENDAUTH,
        "errors" => TokenType::ERRORS,
        "enderrors" => TokenType::ENDERRORS,
    ];

    public function __construct(string $input)
    {
        $this->input = $input;
        $this->read_position = 0;
        $this->read_char();
    }

    public function next_token(): Token
    {
        $tok = new Token();

        $this->skip_whitespace();

        switch ($this->ch) {
            case '(':
                $tok = new Token(TokenType::LPAREN, $this->ch);
                break;
            case ')':
                $tok = new Token(TokenType::RPAREN, $this->ch);
                break;
            case '{':
                if ($this->peek_char() == '{') {
                    $current_ch = $this->ch;
                    $this->read_char();
                    $tok = new Token(TokenType::ASSIGN, $this->ch);
                }
            case '}':
                if ($this->peek_char() == '}') {
                    $current_ch = $this->ch;
                    $this->read_char();
                    $tok = new Token(TokenType::ASSIGN, $this->ch);
                }
                $tok = new Token(TokenType::ENDASSIGN, $this->ch);
                break;
            case "":
                $tok = new Token(TokenType::EOF, '');
                break;
            default:
                // Here should the part where the user defines whatever he wants
                // The expression finishes when the ) or the }} is found
                if (ctype_alpha($this->ch)) {
                    $tok->literal = $this->read_expression();
                    $tok->type = $this->lookup_ident($tok->literal);
                    return $tok;
                } else {
                    $tok = new Token(TokenType::ILLEGAL, $this->ch);
                }
        }

        $this->read_char();
        return $tok;
    }

    /**
     * Checks what is the next char if available
     * @return int|string
     */
    private function peek_char()
    {
        if ($this->read_position >= strlen($this->input)) {
            return 0;
        }
        return $this->input[$this->read_position];
    }

    private function skip_whitespace(): void
    {
        if (in_array($this->ch, [' ', "\r", "\n", "\t"])) {
            $this->read_char();
        }
    }

    private function read_char(): void
    {
        if ($this->read_position >= strlen($this->input)) {
            $this->ch = '';
        } else {
            $this->ch = $this->input[$this->read_position];
        }
        $this->position = $this->read_position;
        $this->read_position += 1;
    }

    private function read_number(): string
    {
        $position = $this->position;

        while (ctype_digit($this->ch)) {
            $this->read_char();
        }

        return substr($this->input, $position, $this->position - $position);
    }

    private function read_expression(): string
    {
        $position = $this->position;

        while ($this->is_letter($this->ch)) {
            $this->read_char();
        }

        return substr($this->input, $position, $this->position - $position);
    }

    private function is_letter(string $string): bool
    {
        return (bool) preg_match("/[a-zA-Z]/", $string);
    }

    private function lookup_ident(string $ident): TokenType
    {
        if (key_exists($ident, self::KEYWORDS)) {
            return self::KEYWORDS[$ident];
        }

        return TokenType::EXPRESSION;
    }
}