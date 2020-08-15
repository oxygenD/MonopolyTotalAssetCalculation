<?php

namespace SocymSlim\Monopoly\exceptions;

use Throwable;
use Psr\Container\ContainerInterface;
use Slim\Interfaces\ErrorRendererInterface;
use Slim\Views\Twig;
use Slim\Error\Renderers\HtmlErrorRenderer;
use Slim\Exception\HttpNotFoundException;
use SocymSlim\Monopoly\exceptions\DataAccessException;

class CustomErrorRenderer implements ErrorRendererInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {

        // エラー詳細を表示する場合
        if ($displayErrorDetails) {
            // SlimのデフォルトHTMLエラーレンダラークラスインスタンスを生成
            $htmlErrorRenderer = new HtmlErrorRenderer();
            $returnHtml = $htmlErrorRenderer($exception, $displayErrorDetails);
        } else {
            $twig = $this->container->get("view");
            // 発生した例外がHttpNotFoundExceptionならば
            if ($exception instanceof HttpNotFoundException) {
                $returnHtml = $twig->fetch("404.html");
            } elseif ($exception instanceof DataAccessException) {
                // 例外インスタンスからメッセージを取得
                $errorMsg = $exception->getMessage();
                $errorMsg .= "もう一度始めからやり直してください。";
                $assign["errorMsg"] = $errorMsg;

                $returnHtml = $twig->fetch("error.html", $assign);
            }
        }
        return $returnHtml;
    }
}
