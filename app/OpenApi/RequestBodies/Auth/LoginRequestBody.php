<?php

namespace App\OpenApi\RequestBodies\Auth;

use App\OpenApi\Schemas\Auth\LoginSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class LoginRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create(self::class)
            ->description('로그인 데이이터 (mobile or email) + password 필수')
            ->content(
                MediaType::json()->schema(LoginSchema::ref())
            );
    }
}
