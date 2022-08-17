<?php

namespace App\OpenApi\Responses\Auth;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Illuminate\Support\Str;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class JoinUserSuccessResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::object(self::class)->properties(
                Schema::string('email')->example('example@example.com'),
                Schema::string('mobile')->example('01012341234'),
                Schema::string('name')->example('박맹자'),
                Schema::string('updated_at')->example('2022-06-10 02:18:57'),
                Schema::string('created_at')->example('2022-06-10 02:18:57'),
                Schema::integer('id')->example(1),
            ),
            Schema::string('access_token')->example(rand(1, 9).'|'.Str::random(50)),
        );

        return Response::create(self::class)
            ->description('유저 정보')
            ->content(MediaType::json()->schema($response));
    }
}
