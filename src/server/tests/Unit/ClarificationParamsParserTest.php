<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Stub\Service\Action\Clarification\ParamsParser;
use App\Stub\Service\Action\Clarification\Parser\LegacyParamsParser;
use App\Stub\Service\Action\Clarification\Parser\SchemaParamsParser;
use App\Stub\Service\Action\Clarification\Parser\SentParamsParser;
use Codeception\Test\Unit;

final class ClarificationParamsParserTest extends Unit
{
    private const RAW_DATA = 'raw_data';
    private const PARSING_RESULT = 'parsing_result';
    private const MOCKS = [
        LegacyParamsParser::class => [
            // success
            [
                self::RAW_DATA => ['avs_data' => ['avs_post_code', 'avs_street_address']],
                self::PARSING_RESULT => ['avs_data.avs_post_code', 'avs_data.avs_street_address'],
            ],
            // failed
            [
                self::RAW_DATA => [],
                self::PARSING_RESULT => [],
            ],
        ],
        SchemaParamsParser::class => [
            // success
            [
                self::RAW_DATA => [
                    'avs_data' => [
                        'type' => 'array',
                        'properties' => [
                            'avs_post_code' => [
                                'description' => 'some'
                            ]
                        ]
                    ]
                ],
                self::PARSING_RESULT => ['avs_data.avs_post_code'],
            ],
            [
                self::RAW_DATA => [
                    'avs_data' => [
                        'type' => 'array',
                        'properties' => [
                            'test' => [
                                'properties' => [
                                    'avs_post_code' => [
                                        'description' => 'some'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                self::PARSING_RESULT => ['avs_data.test.avs_post_code'],
            ],
            // failed
            [
                self::RAW_DATA => [
                    'avs_data' => [
                        'properties' => [
                            'avs_post_code' => [
                                'description' => 'some'
                            ]
                        ]
                    ]
                ],
                self::PARSING_RESULT => [],
            ],
            [
                self::RAW_DATA => [
                    'avs_data' => [
                        'type' => 'array',
                        'avs_post_code' => [
                            'description' => 'some'
                        ]
                    ]
                ],
                self::PARSING_RESULT => ['avs_data.'],
            ],
            [
                self::RAW_DATA => ['avs_data' => 'fhdsajk'],
                self::PARSING_RESULT => [],
            ],
            [
                self::RAW_DATA => ['avs_data' => 23],
                self::PARSING_RESULT => [],
            ],
            [
                self::RAW_DATA => ['avs_data' => ['avs_post_code', 'avs_street_address']],
                self::PARSING_RESULT => [],
            ],
            [
                self::RAW_DATA => [],
                self::PARSING_RESULT => [],
            ],
        ],
        SentParamsParser::class => [
            // success
            [
                self::RAW_DATA => ['avs_data' => ['avs_post_code' => '32134', 'avs_street_address' => 'Ddsa']],
                self::PARSING_RESULT => ['avs_data.avs_post_code', 'avs_data.avs_street_address'],
            ],
            [
                self::RAW_DATA => [
                    'avs_data' => [
                        'test' => [
                            'avs_post_code' => '32134',
                            'avs_street_address' => 'Ddsa'
                        ]
                    ]
                ],
                self::PARSING_RESULT => ['avs_data.test.avs_post_code', 'avs_data.test.avs_street_address'],
            ],
            // failed
            [
                self::RAW_DATA => [],
                self::PARSING_RESULT => [],
            ],
        ],
    ];

    public function testLegacyParamsParser(): void
    {
        $this->testParser(LegacyParamsParser::class);
    }

    public function testSchemaParamsParser(): void
    {
        $this->testParser(SchemaParamsParser::class);
    }

    public function testSentParamsParser(): void
    {
        $this->testParser(SentParamsParser::class);
    }

    private function testParser(string $testingClassName): void
    {
        foreach (self::MOCKS[$testingClassName] as $config) {
            $rawData = $config[self::RAW_DATA];
            $parsingResult = $config[self::PARSING_RESULT];
            $instance = new $testingClassName($rawData);

            $this->assertInstanceOf(ParamsParser::class, $instance);

            if ($instance instanceof ParamsParser) {
                $this->assertEquals($instance->getNames(), $parsingResult);
            }
        }
    }
}
