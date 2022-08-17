<?php

namespace App\OpenApi\Responses\Common;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ValidateResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::string('message')->title('에러 메시지')->example('The password field is required.'),
            Schema::object('errors')
                ->title('에러 항목 Key List')
                ->additionalProperties(
                    Schema::array()->title('에러 사유')->items(Schema::string())
                )
                ->example(['password' => ['The password field is required..']])
        );

        return Response::create('ValidateFail')
            ->description('필수 항목 누락 및 자료형 Miss')
            ->content(
                MediaType::json()->schema($response)
            );
    }
}
