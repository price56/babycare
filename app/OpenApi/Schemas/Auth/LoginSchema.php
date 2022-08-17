<?php

namespace App\OpenApi\Schemas\Auth;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class LoginSchema extends SchemaFactory implements Reusable
{
    /**
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object(self::class)
            ->properties(
                Schema::string('email')->example('test@test.com')->title('이메일'),
                Schema::string('mobile')->example('01000000000')->title('전화번호'),
                Schema::string('password')->example('password')->title('비밀번호'),
            )
            ->required('email', 'password');
    }
}
