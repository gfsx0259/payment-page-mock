<?php

use App\Command\Fixture\Dto\RouteDto;
use App\Command\Fixture\Dto\ScenarioDto;

return [
    new RouteDto(
        'card/sale',
        description: '...',
        logo: 'card.svg',
        type: 1,
        scenarios: [
            new ScenarioDto('Simple test', true, callbacks: ['card/purchase/simple-success-1'])
        ]
    ),
    new RouteDto(
        'wallet/kakaopay/sale',
        description: '...',
        logo: 'kakaopay.svg',
        type: 3,
        scenarios: []
    ),
    new RouteDto(
        'wallet/gcash/sale',
        description: '...',
        logo: 'gcash.svg',
        type: 3,
        scenarios: [
            new ScenarioDto('Simple test', true, callbacks: ['gcash/simple-success-1'])
        ]
    ),
];
