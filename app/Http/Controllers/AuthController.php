<?php

namespace App\Http\Controllers;

use App\Events\UserJoinEvent;
use App\Exceptions\ApiException;
use App\Http\Requests\JoinRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\WithDrawRequest;
use App\OpenApi\RequestBodies\Auth\AuthJoinRequestBody;
use App\OpenApi\RequestBodies\Auth\LoginRequestBody;
use App\OpenApi\Responses\Auth\JoinUserSuccessResponse;
use App\OpenApi\Responses\Auth\LoginResponse;
use App\OpenApi\Responses\Common\UnAuthResponse;
use App\OpenApi\Responses\Common\ValidateResponse;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {

    }

    /**
     * 회원 로그인
     *
     * 이메일 또는 모바일로 로그인.
     *
     */
    #[OpenApi\Operation(tags: ['auth'], method: 'POST')]
    #[OpenApi\RequestBody(factory: LoginRequestBody::class)]
    #[OpenApi\Response(factory: LoginResponse::class, statusCode: 200, description: '인증 성공')]
    #[OpenApi\Response(factory: UnAuthResponse::class, statusCode: 401, description: '인증 실패')]
    #[OpenApi\Response(factory: ValidateResponse::class, statusCode: 422, description: '검증 실패')]
    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->authService->loginUser($request->authId(), $request->password());

        return $this->responseJson([
            'access_token' => $this->authService->createToken($user),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return $this->responseJson([
            'message' => 'success',
        ]);
    }

    /**
     * 회원가입
     *
     * 회원정보를 받아서 회원가입을 한다. <br />
     * 이메일, 전화번호는 중복될수 없다. <br />
     * 비밀번호 규칙은 8-32자, 영문,숫자 조합 <br /><br />
     * `필수항목` <br /><br />
     * 이름, 이메일, 전화번호, 비밀번호, 비밀번호 확인 <br /><br />
     *
     * @throws \Throwable
     */
    #[OpenApi\Operation(tags: ['auth'], method: 'POST')]
    #[OpenApi\RequestBody(factory: AuthJoinRequestBody::class)]
    #[OpenApi\Response(factory: JoinUserSuccessResponse::class, statusCode: 201, description: '회원 가입')]
    #[OpenApi\Response(factory: ValidateResponse::class, statusCode: 422, description: '검증 실패')]
    public function join(JoinRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $user = $this->authService->join($request->joinUserData());

            UserJoinEvent::dispatch($user->id);

            return $this->responseJson([
                'user' => $user,
                'access_token' => $this->authService->createToken($user),
            ], 201);
        });
    }

    public function withDraw(WithDrawRequest $request): JsonResponse
    {
        $user = $request->user();

        $this->authService->checkUserPassword($request->get('password'));

        $this->authService->withdrawUserAccount($user);

        return $this->responseJson([], 204);
    }
}
