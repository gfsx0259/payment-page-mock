<?php

use App\Command\Fixture\Dto\RouteDto;
use App\Command\Fixture\Dto\ScenarioDto;

const
    ROUTE_TYPE_CARD = 1,
    ROUTE_TYPE_REDIRECT = 2,
    ROUTE_TYPE_QR = 3;

return [
    new RouteDto(
        'card/sale',
        logo: 'card.svg',
        type: ROUTE_TYPE_CARD,
        scenarios: [
            new ScenarioDto('Success', true, telegramAlias: '@kopopov', callbacks: ['card/purchase/success']),
            new ScenarioDto('Decline', true, telegramAlias: '@kopopov', callbacks: ['card/purchase/decline']),
            new ScenarioDto('Error', true, telegramAlias: '@kopopov', callbacks: ['card/purchase/error']),
            new ScenarioDto('Clarification', true, telegramAlias: '@fsafsd', callbacks: [
                'card/purchase/clarification-0',
                'card/purchase/clarification-1',
                'card/purchase/clarification-2',
            ]),
            new ScenarioDto('3ds', true, telegramAlias: '@kopopov', callbacks: [
                'card/purchase/3ds-0',
                'card/purchase/3ds-1',
            ]),
            new ScenarioDto('3ds challenge', true, telegramAlias: '@fsafsd', callbacks: [
                'card/purchase/3ds-challenge-0',
                'card/purchase/3ds-challenge-1',
                'card/purchase/3ds-challenge-2',
            ]),
            new ScenarioDto('3ds proxy (legacy PP) frictionless', true, telegramAlias: '@kopopov', callbacks: [
                'card/purchase/3ds-proxy-frictionless-0',
                'card/purchase/3ds-proxy-frictionless-1',
                'card/purchase/3ds-proxy-frictionless-2',
            ]),
        ],
    ),
    new RouteDto(
        'wallet/kakaopay/sale',
        logo: 'kakaopay.svg',
        type: ROUTE_TYPE_QR,
        scenarios: [
            new ScenarioDto('Success', true, telegramAlias: '@kopopov', callbacks: [
                'kakaopay/success-0',
                'kakaopay/success-1',
            ]),
        ],
    ),
    new RouteDto(
        'wallet/gcash/sale',
        logo: 'gcash.svg',
        type: ROUTE_TYPE_REDIRECT,
        scenarios: [
            new ScenarioDto('Success', true, telegramAlias: '@kopopov', callbacks: [
                'gcash/success-0',
                'gcash/success-1',
            ]),
        ],
    ),
    new RouteDto(
        'pix/sale',
        logo: 'pix.svg',
        type: ROUTE_TYPE_QR,
        scenarios: [
            new ScenarioDto('Success', true, telegramAlias: '@kopopov', callbacks: [
                'pix/success-0',
                'pix/success-1',
                'pix/success-2',
            ]),
        ],
    ),
    new RouteDto(
        'banks/estonia/sale',
        logo: 'neofinance.svg',
        type: ROUTE_TYPE_REDIRECT,
        scenarios: [
            new ScenarioDto('Success', true, telegramAlias: '@kopopov', callbacks: [
                'neofinance/success-0',
                'neofinance/success-1',
            ]),
        ],
    ),
    new RouteDto(
        'googlepay/sale',
        logo: 'googlepay.svg',
        type: ROUTE_TYPE_CARD,
        scenarios: [
            new ScenarioDto('Success', true, telegramAlias: '@kopopov', callbacks: ['googlepay/success']),
        ],
    ),
    new RouteDto(
        'banks/france/sale',
        logo: 'banks-france.svg',
        type: ROUTE_TYPE_REDIRECT,
        scenarios: [
            new ScenarioDto('Success', true, telegramAlias: '@kopopov', callbacks: [
                'banks/france/success-0',
                'banks/france/success-1',
            ]),
        ],
    ),
    new RouteDto(
        'online-banking/trustly/sale',
        logo: 'trustly.svg',
        type: ROUTE_TYPE_REDIRECT,
        scenarios: [
            new ScenarioDto('Success', true, telegramAlias: '@kopopov', callbacks: ['trustly/success']),
        ],
    ),
    new RouteDto(
        'wallet/paypal/sale',
        logo: 'paypal.svg',
        type: ROUTE_TYPE_REDIRECT,
        scenarios: [
            new ScenarioDto('Success', true, telegramAlias: '@kopopov', callbacks: [
                'paypal/success-0',
                'paypal/success-1',
            ]),
        ],
    ),
    new RouteDto(
        'wallet/neteller/sale',
        logo: 'neteller.svg',
        type: ROUTE_TYPE_REDIRECT,
        scenarios: [
            new ScenarioDto('Success', true, telegramAlias: '@kopopov', callbacks: [
                'neteller/success-0',
                'neteller/success-1',
            ]),
        ],
    ),
    new RouteDto(
        'bank-transfer/klarna/sale',
        logo: 'klarna.svg',
        type: ROUTE_TYPE_REDIRECT,
        scenarios: [
            new ScenarioDto('Success', true, telegramAlias: '@kopopov', callbacks: [
                'klarna/success-0',
                'klarna/success-1',
            ]),
        ],
    ),
    new RouteDto(
        'online-banking/giropay/sale',
        logo: 'giropay.svg',
        type: ROUTE_TYPE_REDIRECT,
        scenarios: [
            new ScenarioDto('Clarification Success', true, telegramAlias: '@kopopov', callbacks: [
                'giropay/success-0',
                'giropay/success-1',
                'giropay/success-2',
            ]),
        ],
    ),
    new RouteDto(
        'skrill/sale',
        logo: 'skrill.svg',
        type: ROUTE_TYPE_REDIRECT,
        scenarios: [
            new ScenarioDto('Success', true, telegramAlias: '@kopopov', callbacks: [
                'skrill/success-0',
                'skrill/success-1',
            ]),
        ],
    ),
];
