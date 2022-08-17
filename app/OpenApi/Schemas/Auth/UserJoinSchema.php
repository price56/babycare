<?php

namespace App\OpenApi\Schemas\Auth;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class UserJoinSchema extends SchemaFactory implements Reusable
{
    /**
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object(self::class)
            ->properties(
                Schema::string('name')->example('박맹자')->title('이름'),
                Schema::string('email')->example('test@test.com')->title('이메일'),
                Schema::string('mobile')->example('01000000000')->title('전화번호'),
                Schema::string('password')->example('password1234')->title('비밀번호'),
                Schema::string('password_confirmation')->example('password1234')->title('비밀번호 확인'),
            )
            ->required('email', 'password', 'password_confirmation', 'mobile');
    }
}
