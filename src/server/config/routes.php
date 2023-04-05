<?php

declare(strict_types=1);

use App\Auth\Controller\AuthController;
use App\Auth\Controller\SignupController;
use App\Blog\Archive\ArchiveController;
use App\Blog\BlogController;
use App\Blog\CommentController;
use App\Blog\Post\PostController;
use App\Blog\Post\PostRepository;
use App\Blog\Tag\TagController;
use App\Contact\ContactController;
use App\Controller\Actions\ApiInfo;
use App\Controller\SiteController;
use App\Middleware\AccessChecker;
use App\Middleware\ApiDataWrapper;
use App\Middleware\ApiRequestParser;
use App\Stub\ActionController;
use App\Stub\Api\CallbackController;
use App\Stub\Api\ResourceController;
use App\Stub\Api\RouteController;
use App\Stub\Api\StubController as ApiStubController;
use App\Stub\DummyPageController;
use App\Stub\StaticController;
use App\Stub\StubController;
use App\User\Controller\ApiUserController;
use App\User\Controller\UserController;
use Psr\Http\Message\ServerRequestInterface;
use Tuupola\Middleware\CorsMiddleware;
use Yiisoft\Auth\Middleware\Authentication;
use Yiisoft\Csrf\CsrfMiddleware;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\DataResponse\Middleware\FormatDataResponseAsHtml;
use Yiisoft\DataResponse\Middleware\FormatDataResponseAsJson;
use Yiisoft\DataResponse\Middleware\FormatDataResponseAsXml;
use Yiisoft\Http\Method;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;
use Yiisoft\Swagger\Middleware\SwaggerJson;
use Yiisoft\Swagger\Middleware\SwaggerUi;
use Yiisoft\Yii\Middleware\HttpCache;

return [
    // Lonely pages of site
    Route::get('/')
        ->action([SiteController::class, 'index'])
        ->name('site/index'),
    Route::methods([Method::GET, Method::POST], '/contact')
        ->action([ContactController::class, 'contact'])
        ->name('site/contact'),

    // Auth
    Route::methods([Method::GET, Method::POST], '/login')
        ->action([AuthController::class, 'login'])
        ->name('auth/login'),
    Route::post('/logout')
        ->action([AuthController::class, 'logout'])
        ->name('auth/logout'),
    Route::methods([Method::GET, Method::POST], '/signup')
        ->action([SignupController::class, 'signup'])
        ->name('auth/signup'),

    // User
    Group::create('/user')
        ->routes(
        // Index
            Route::get('[/page-{page:\d+}]')
                ->action([UserController::class, 'index'])
                ->name('user/index'),
            // Profile page
            Route::get('/{login}')
                ->action([UserController::class, 'profile'])
                ->name('user/profile')
        ),

    // API group.
    // By default it responds with XML regardless of content-type.
    // Individual sub-routes are responding with JSON.
    Group::create('/api')
        ->middleware(FormatDataResponseAsXml::class)
        ->middleware(ApiDataWrapper::class)
        ->routes(
            Route::get('/info/v1')
                ->name('api/info/v1')
                ->action(function (DataResponseFactoryInterface $responseFactory) {
                    return $responseFactory->createResponse(['version' => '1.0', 'author' => 'yiisoft']);
                }),
            Route::get('/info/v2')
                ->name('api/info/v2')
                ->middleware(FormatDataResponseAsJson::class)
                ->action(ApiInfo::class),
            Route::get('/user')
                ->name('api/user/index')
                ->action([ApiUserController::class, 'index']),
            Route::get('/user/{login}')
                ->name('api/user/profile')
                ->middleware(FormatDataResponseAsJson::class)
                ->action([ApiUserController::class, 'profile']),

            Group::create()
                ->middleware(FormatDataResponseAsJson::class)
                ->middleware(CorsMiddleware::class)
                ->disableMiddleware(CsrfMiddleware::class)
                ->routes(
                    Route::get('/route')
                        ->name('api/route/index')
                        ->action([RouteController::class, 'index']),
                    Route::methods([Method::OPTIONS, Method::POST], '/route')
                        ->middleware(ApiRequestParser::class)
                        ->name('api/route/create')
                        ->action([RouteController::class, 'create']),
                    Route::methods([Method::PUT], '/route')
                        ->middleware(ApiRequestParser::class)
                        ->name('api/route/update')
                        ->action([RouteController::class, 'update']),
                    Route::methods([Method::OPTIONS, Method::DELETE], '/route/{id}')
                        ->action([RouteController::class, 'delete']),

                    Route::get('/stub/{routeId}')
                        ->name('api/stub/index')
                        ->action([ApiStubController::class, 'index']),
                    Route::methods([Method::OPTIONS, Method::POST], '/stub')
                        ->name('api/stub/create')
                        ->action([ApiStubController::class, 'create']),
                    Route::methods([Method::PUT], '/stub')
                        ->name('api/stub/update')
                        ->action([ApiStubController::class, 'update']),
                    Route::methods([Method::OPTIONS, Method::DELETE], '/stub/{id}')
                        ->name('api/stub/delete')
                        ->action([ApiStubController::class, 'delete']),
                    Route::methods([Method::OPTIONS, Method::POST], '/stub/setDefault')
                        ->name('api/stub/setDefault')
                        ->action([ApiStubController::class, 'setDefault']),

                    Route::get('/callback/{stubId}')
                        ->action([CallbackController::class, 'index']),
                    Route::patch('/callback/{stubId}')
                        ->action([CallbackController::class, 'changeOrder'])
                        ->name('api/callback/changeOrder'),
                    Route::methods([Method::OPTIONS, Method::POST], '/stub/callback')
                        ->action([CallbackController::class, 'update']),
                    Route::methods([Method::OPTIONS, Method::DELETE], '/callback/{id}')
                        ->action([CallbackController::class, 'delete']),

                    Route::get('/resource')
                        ->action([ResourceController::class, 'index']),
                    Route::get('/resource/template-variables')
                        ->action([ResourceController::class, 'getTemplateVariables']),
                    Route::methods([Method::OPTIONS, Method::POST], '/resource')
                        ->name('api/resource/create')
                        ->action([ResourceController::class, 'create']),
                    Route::methods([Method::PUT], '/resource')
                        ->name('api/resource/update')
                        ->action([ResourceController::class, 'update']),
                    Route::methods([Method::OPTIONS, Method::DELETE], '/resource/{id}')
                        ->name('api/resource/delete')
                        ->action([ResourceController::class, 'delete']),
                ),
        ),

    Group::create('/v2')
        ->middleware(FormatDataResponseAsJson::class)
        ->middleware(CorsMiddleware::class)
        ->disableMiddleware(CsrfMiddleware::class)
        ->routes(
            Route::methods([Method::OPTIONS, Method::POST], '/info/check/signature')
                ->action(function (DataResponseFactoryInterface $responseFactory) {
                    return $responseFactory->createResponse();
                }),
            Route::methods([Method::OPTIONS, Method::POST], '/payment/status')
                ->action([StubController::class, 'status']),
            Route::post('/payment/status/request')
                ->action([StubController::class, 'statusByRequest']),

            Route::post('/payment/{route:[\w\/-_]+}')
                ->action([StubController::class, 'sale']),
            Route::post('/payment/card/3ds_result')
                ->action([ActionController::class, 'completeAcs']),
            Route::post('/payment/card/3ds_check_iframe')
                ->action([ActionController::class, 'completeAcs']),
            Route::post('/payment/clarification')
                ->action([ActionController::class, 'completeClarification']),
        ),

    Group::create('/actions')
        ->disableMiddleware(CsrfMiddleware::class)
        ->routes(
            Route::post('/renderAcs')
                ->name('actions/renderAcs')
                ->action([DummyPageController::class, 'renderAcs']),
            Route::methods([Method::GET, Method::POST], '/renderAcsIframe/{uniqueKey}')
                ->name('actions/renderAcsIframe')
                ->action([DummyPageController::class, 'renderAcsIframe']),
            Route::methods([Method::GET, Method::POST], '/renderAcsRedirect/{uniqueKey}')
                ->name('actions/renderAcsRedirect')
                ->action([DummyPageController::class, 'renderAcsRedirect']),
            Route::methods([Method::GET, Method::POST], '/renderAps/{uniqueKey}')
                ->name('actions/renderAps')
                ->action([DummyPageController::class, 'renderAps']),
            Route::methods([Method::GET], '/renderConfirmationQr/{uniqueKey}')
                ->name('actions/renderConfirmationQr')
                ->action([DummyPageController::class, 'renderConfirmationQr']),
            Route::post('/completeAps')
                ->name('actions/completeAps')
                ->action([ActionController::class, 'completeAps']),
            Route::post('/completeConfirmationQr')
                ->name('actions/completeConfirmationQr')
                ->action([ActionController::class, 'completeConfirmationQr']),
        ),

    Group::create()
        ->middleware(CorsMiddleware::class)
        ->disableMiddleware(CsrfMiddleware::class)
        ->routes(
            Route::methods([Method::GET, Method::POST], '{destination:[\/\-\w.]+}')
                ->action([StaticController::class, 'render'])
        ),

    // Blog routes
    Group::create('/blog')
        ->routes(
        // Index
            Route::get('[/page{page:\d+}]')
                ->middleware(
                    fn (HttpCache $httpCache, PostRepository $postRepository) =>
                    $httpCache->withLastModified(function (ServerRequestInterface $request, $params) use ($postRepository) {
                        return $postRepository->getMaxUpdatedAt()->getTimestamp();
                    })
                )
                ->action([BlogController::class, 'index'])
                ->name('blog/index'),
            // Add Post page
            Route::methods([Method::GET, Method::POST], '/page/add')
                ->middleware(Authentication::class)
                ->action([PostController::class, 'add'])
                ->name('blog/add'),
            // Edit Post page
            Route::methods([Method::GET, Method::POST], '/page/edit/{slug}')
                ->name('blog/edit')
                ->middleware(Authentication::class)
                ->middleware(fn (AccessChecker $checker) => $checker->withPermission('editPost'))
                ->action([PostController::class, 'edit']),

            // Post page
            Route::get('/page/{slug}')
                ->middleware(
                    fn (HttpCache $httpCache, PostRepository $postRepository, CurrentRoute $currentRoute) =>
                    $httpCache->withEtagSeed(function (ServerRequestInterface $request, $params) use ($postRepository, $currentRoute) {
                        $post = $postRepository->findBySlug($currentRoute->getArgument('slug'));
                        return $post->getSlug() . '-' . $post->getUpdatedAt()->getTimestamp();
                    })
                )
                ->action([PostController::class, 'index'])
                ->name('blog/post'),
            // Tag page
            Route::get('/tag/{label}[/page{page:\d+}]')
                ->action([TagController::class, 'index'])
                ->name('blog/tag'),
            // Archive
            Group::create('/archive')
                ->routes(
                // Index page
                    Route::get('')
                        ->action([ArchiveController::class, 'index'])
                        ->name('blog/archive/index'),
                    // Yearly page
                    Route::get('/{year:\d+}')
                        ->action([ArchiveController::class, 'yearlyArchive'])
                        ->name('blog/archive/year'),
                    // Monthly page
                    Route::get('/{year:\d+}-{month:\d+}[/page{page:\d+}]')
                        ->action([ArchiveController::class, 'monthlyArchive'])
                        ->name('blog/archive/month'),
                ),
            // comments
            Route::get('/comments/[next/{next}]')
                ->action([CommentController::class, 'index'])
                ->name('blog/comment/index')
        ),

    // Swagger routes
    Group::create('/swagger')
        ->routes(
            Route::get('')
                ->middleware(FormatDataResponseAsHtml::class)
                ->action(fn (SwaggerUi $swaggerUi) => $swaggerUi->withJsonUrl('/swagger/json-url'))
                ->name('swagger/index'),
            Route::get('/json-url')
                ->middleware(FormatDataResponseAsJson::class)
                ->action(SwaggerJson::class),
        ),
];
