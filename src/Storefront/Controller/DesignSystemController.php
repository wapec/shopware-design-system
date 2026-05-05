<?php

declare(strict_types=1);

namespace Swds\DesignSystem\Storefront\Controller;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Controller\StorefrontController;
use Shopware\Storefront\Page\GenericPageLoader;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(defaults: ['_routeScope' => ['storefront']])]
class DesignSystemController extends StorefrontController
{
    public function __construct(
        private readonly GenericPageLoader $genericPageLoader,
        private readonly SystemConfigService $systemConfigService
    ) {
    }

    #[Route(path: '/design-system', name: 'frontend.design_system.index', methods: ['GET'])]
    public function index(Request $request, SalesChannelContext $context): Response
    {
        $salesChannelId = $context->getSalesChannel()->getId();
        $isAccessible = $this->systemConfigService->get(
            'ShopwareDesignSystem.config.isDesignSystemAccessible',
            $salesChannelId
        );

        if (!$isAccessible) {
            return new RedirectResponse('/', Response::HTTP_FOUND);
        }

        $page = $this->genericPageLoader->load($request, $context);

        return $this->renderStorefront(
            '@ShopwareDesignSystem/storefront/page/design-system/index.html.twig',
            ['page' => $page]
        );
    }
}
