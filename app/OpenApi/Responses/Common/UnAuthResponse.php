<?php

namespace App\OpenApi\Responses\Common;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class UnAuthResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::string('message')->title('Unauthenticated')->default('Unauthenticated'),
        );

        return Response::create(self::class)
            ->description('Unauthenticated')
            ->content(MediaType::json()->schema($response));
    }
}
