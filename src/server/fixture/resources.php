<?php

use App\Command\Fixture\Dto\ResourceDto;

return [
    new ResourceDto(
        path: '/neofinance.js',
        alias: 'NEOFINANCE_JS',
        contentPath: 'neofinance.js',
        contentType: 'application/javascript'
    ),
    new ResourceDto(
        path: '/v2/info/banks/estonia/sale/list',
        alias: 'ESTONIA_BANKS_LIST',
        contentPath: 'banks/estonia.json'
    ),
    new ResourceDto(
        path: '/v2/info/banks/france/sale/list',
        alias: 'FRENCH_BANKS_LIST',
        contentPath: 'banks/france.json'
    ),
    new ResourceDto(
        path: '/v2/customer/saved_account/list',
        alias: 'ACCOUNTS',
        contentPath: 'accounts.json'
    ),
    new ResourceDto(
        path: '/v2/customer/info',
        alias: 'CUSTOMER_INFO',
        contentPath: 'customer.json'
    ),
    new ResourceDto(
        path: '/v2/info/get_merchant_params',
        alias: 'GOOGLE_PAY_MA',
        contentPath: 'google/ma.json'
    ),
    new ResourceDto(
        path: '/v2/info/get_route',
        alias: 'GOOGLE_PAY_ROUTE',
        contentPath: 'google/route.json'
    ),
    new ResourceDto(
        path: '/card_type_regex/?preset=default',
        alias: 'DICT_CARD_TYPE_DEFAULT',
        contentPath: 'card/default.json'
    ),
    new ResourceDto(
        path: '/card_type_regex/?preset=mir',
        alias: 'DICT_CARD_TYPE_MIR',
        contentPath: 'card/mir.json'
    ),
];
