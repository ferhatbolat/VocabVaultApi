<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="Kullanıcı kimlik doğrulama işlemleri"
 * )
 */
class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *     path="/auth/social-login",
     *     tags={"Authentication"},
     *     summary="Sosyal medya ile giriş/kayıt",
     *     description="Gmail, Facebook veya Apple ile kullanıcı girişi/kaydı yapar",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "name", "provider", "provider_id"},
     *             @OA\Property(property="email", type="string", format="email", example="user@gmail.com", description="Kullanıcı email adresi"),
     *             @OA\Property(property="name", type="string", example="John Doe", description="Kullanıcı adı"),
     *             @OA\Property(property="provider", type="string", enum={"google", "facebook", "apple"}, example="google", description="Sosyal medya sağlayıcısı"),
     *             @OA\Property(property="provider_id", type="string", example="123456789", description="Sosyal medya platform kullanıcı ID'si"),
     *             @OA\Property(property="avatar", type="string", format="url", example="https://example.com/avatar.jpg", description="Profil resmi URL'si (opsiyonel)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Giriş başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Login successful"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="user@gmail.com"),
     *                 @OA\Property(property="provider", type="string", example="google"),
     *                 @OA\Property(property="provider_id", type="string", example="123456789"),
     *                 @OA\Property(property="avatar", type="string", example="https://example.com/avatar.jpg"),
     *                 @OA\Property(property="email_verified_at", type="string", format="datetime", example="2024-01-01T00:00:00.000000Z"),
     *                 @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01T00:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01T00:00:00.000000Z")
     *             ),
     *             @OA\Property(property="token", type="string", example="1|abcdefghijklmnopqrstuvwxyz", description="API erişim token'ı")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasyon hatası",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object", example={"email": {"The email field is required."}})
     *         )
     *     )
     * )
     */
    public function socialLogin(Request $request)
    {
        return $this->userService->socialLogin($request);
    }

    /**
     * @OA\Post(
     *     path="/auth/register",
     *     tags={"Authentication"},
     *     summary="Normal kayıt",
     *     description="Email ve şifre ile yeni kullanıcı kaydı yapar",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="John Doe", description="Kullanıcı adı"),
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com", description="Email adresi"),
     *             @OA\Property(property="password", type="string", format="password", example="password123", description="Şifre (minimum 8 karakter)"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123", description="Şifre onayı")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Kayıt başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Registration successful"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="user@example.com"),
     *                 @OA\Property(property="provider", type="string", example=null),
     *                 @OA\Property(property="provider_id", type="string", example=null),
     *                 @OA\Property(property="avatar", type="string", example=null),
     *                 @OA\Property(property="email_verified_at", type="string", example=null),
     *                 @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01T00:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01T00:00:00.000000Z")
     *             ),
     *             @OA\Property(property="token", type="string", example="2|abcdefghijklmnopqrstuvwxyz", description="API erişim token'ı")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasyon hatası",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object", example={"email": {"The email has already been taken."}})
     *         )
     *     )
     * )
     */
    public function register(Request $request)
    {
        return $this->userService->regularRegister($request);
    }

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"Authentication"},
     *     summary="Normal giriş",
     *     description="Email ve şifre ile kullanıcı girişi yapar",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com", description="Email adresi"),
     *             @OA\Property(property="password", type="string", format="password", example="password123", description="Şifre")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Giriş başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Login successful"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="user@example.com"),
     *                 @OA\Property(property="provider", type="string", example=null),
     *                 @OA\Property(property="provider_id", type="string", example=null),
     *                 @OA\Property(property="avatar", type="string", example=null),
     *                 @OA\Property(property="email_verified_at", type="string", example=null),
     *                 @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01T00:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01T00:00:00.000000Z")
     *             ),
     *             @OA\Property(property="token", type="string", example="3|abcdefghijklmnopqrstuvwxyz", description="API erişim token'ı")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Geçersiz kimlik bilgileri",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid credentials")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasyon hatası",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object", example={"email": {"The email field is required."}})
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        return $this->userService->regularLogin($request);
    }

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     tags={"Authentication"},
     *     summary="Çıkış",
     *     description="Kullanıcı çıkışı yapar ve aktif token'ı iptal eder",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Çıkış başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logout successful")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Yetkisiz erişim",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        return $this->userService->logout($request);
    }
}
