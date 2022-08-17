<?php

namespace App\OpenApi\RequestBodies\Auth;

use App\OpenApi\Schemas\Auth\UserJoinSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class AuthJoinRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create(self::class)
            ->description('회원 가입 데이터')
            ->content(
                MediaType::json()->schema(UserJoinSchema::ref())
            );
    }
}
