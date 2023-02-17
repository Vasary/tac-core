<?php

declare(strict_types = 1);

namespace App\Tests\Presentation\API\Product;

final class CreateProductObject
{
    public const ATTRIBUTE_VALUE_CREATED_0 = <<<JSON
{"attributeValue":{"id":"20e90cb7-0f31-4804-bb42-9122e0d670e8","attribute":{"id":"cd684b54-632f-48c2-a630-c08d70526234","code":"color","type":"string","name":"name","description":"description","value":"black"},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_UPDATED_0 = <<<JSON
{"attributeValue":{"id":"20e90cb7-0f31-4804-bb42-9122e0d670e8","attribute":{"id":"cd684b54-632f-48c2-a630-c08d70526234","code":"color","type":"string","name":"name","description":"description","value":"black"},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_CREATED_1 = <<<JSON
{"attributeValue":{"id":"a36e9f12-725a-4ed6-b2cb-0321d529ea66","attribute":{"id":"7a5b0941-43b6-41f7-baff-ad39432abb67","code":"connectivity","type":"array","name":"name","description":"description","value":null},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_UPDATED_1 = <<<JSON
{"attributeValue":{"id":"a36e9f12-725a-4ed6-b2cb-0321d529ea66","attribute":{"id":"7a5b0941-43b6-41f7-baff-ad39432abb67","code":"connectivity","type":"array","name":"name","description":"description","value":null},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_CREATED_2 = <<<JSON
{"attributeValue":{"id":"ee69915a-5a4a-4399-aa28-4322da2f2c9b","attribute":{"id":"fee8f295-7b19-4d94-8245-1690ab054ad7","code":"dvi","type":"string","name":"name","description":"description","value":"true"},"parent":"7a5b0941-43b6-41f7-baff-ad39432abb67","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_UPDATED_2 = <<<JSON
{"attributeValue":{"id":"ee69915a-5a4a-4399-aa28-4322da2f2c9b","attribute":{"id":"fee8f295-7b19-4d94-8245-1690ab054ad7","code":"dvi","type":"string","name":"name","description":"description","value":"true"},"parent":"7a5b0941-43b6-41f7-baff-ad39432abb67","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_CREATED_3 = <<<JSON
{"attributeValue":{"id":"c532b5e2-3eb4-4b60-9dd6-4797f7642305","attribute":{"id":"ed7257c6-50c1-499b-8900-b46d254a51ff","code":"hdmi","type":"boolean","name":"name","description":"description","value":true},"parent":"7a5b0941-43b6-41f7-baff-ad39432abb67","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_UPDATED_3 = <<<JSON
{"attributeValue":{"id":"c532b5e2-3eb4-4b60-9dd6-4797f7642305","attribute":{"id":"ed7257c6-50c1-499b-8900-b46d254a51ff","code":"hdmi","type":"boolean","name":"name","description":"description","value":true},"parent":"7a5b0941-43b6-41f7-baff-ad39432abb67","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_CREATED_4 = <<<JSON
{"attributeValue":{"id":"05462bb0-444d-4101-9a94-d607724b3047","attribute":{"id":"fa9c421a-dcb1-4e97-becd-c19e11d31c0c","code":"usb","type":"boolean","name":"name","description":"description","value":false},"parent":"7a5b0941-43b6-41f7-baff-ad39432abb67","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_UPDATED_4 = <<<JSON
{"attributeValue":{"id":"05462bb0-444d-4101-9a94-d607724b3047","attribute":{"id":"fa9c421a-dcb1-4e97-becd-c19e11d31c0c","code":"usb","type":"boolean","name":"name","description":"description","value":false},"parent":"7a5b0941-43b6-41f7-baff-ad39432abb67","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_CREATED_5 = <<<JSON
{"attributeValue":{"id":"a0e48991-64c5-4e2d-9c33-c2e9d5150bcc","attribute":{"id":"829636fe-62cc-4349-9246-de9fa94778d5","code":"year","type":"integer","name":"name","description":"description","value":2022},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_UPDATED_5 = <<<JSON
{"attributeValue":{"id":"a0e48991-64c5-4e2d-9c33-c2e9d5150bcc","attribute":{"id":"829636fe-62cc-4349-9246-de9fa94778d5","code":"year","type":"integer","name":"name","description":"description","value":2022},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_CREATED_6 = <<<JSON
{"attributeValue":{"id":"f5812d3c-c6a2-49be-b02d-c1786c93c023","attribute":{"id":"a794af18-7542-400c-8c22-740bf5b0620e","code":"manufacturer","type":"string","name":"name","description":"description","value":"LG"},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_UPDATED_6 = <<<JSON
{"attributeValue":{"id":"f5812d3c-c6a2-49be-b02d-c1786c93c023","attribute":{"id":"a794af18-7542-400c-8c22-740bf5b0620e","code":"manufacturer","type":"string","name":"name","description":"description","value":"LG"},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_CREATED_7 = <<<JSON
{"attributeValue":{"id":"2560f92f-5257-4b43-a5be-bc89036deb34","attribute":{"id":"6323609e-d9da-4d4d-bde0-d101edb0d51b","code":"sale","type":"boolean","name":"name","description":"description","value":false},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_UPDATED_7 = <<<JSON
{"attributeValue":{"id":"2560f92f-5257-4b43-a5be-bc89036deb34","attribute":{"id":"6323609e-d9da-4d4d-bde0-d101edb0d51b","code":"sale","type":"boolean","name":"name","description":"description","value":false},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_CREATED_8 = <<<JSON
{"attributeValue":{"id":"2ef9ee43-898f-4004-a312-56571eeb010b","attribute":{"id":"9d0b79cb-d621-4de6-98dd-0d08000533a8","code":"recommendation","type":"boolean","name":"name","description":"description","value":true},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const ATTRIBUTE_VALUE_UPDATED_8 = <<<JSON
{"attributeValue":{"id":"2ef9ee43-898f-4004-a312-56571eeb010b","attribute":{"id":"9d0b79cb-d621-4de6-98dd-0d08000533a8","code":"recommendation","type":"boolean","name":"name","description":"description","value":true},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const GLOSSARY_NAME = <<<JSON
{"glossary":{"objectId":"af3de651-754b-4dbe-89ee-ca6cbb7549f0","field":"name","value":"Monitor","locale":"en"}}
JSON;

    public const GLOSSARY_DESCRIPTION = <<<JSON
{"glossary":{"objectId":"af3de651-754b-4dbe-89ee-ca6cbb7549f0","field":"description","value":"There is a simple nice monitor","locale":"en"}}
JSON;

    public const PRODUCT = <<<JSON
{"product":{"id":"af3de651-754b-4dbe-89ee-ca6cbb7549f0","name":"Monitor","description":"There is a simple nice monitor","creator":"mock|10101011","attributes":[],"category":"6b58caa4-0571-44db-988a-8a75f86b2520","units":[],"createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const PRODUCT_UPDATE_0 = <<<JSON
{"product":{"id":"af3de651-754b-4dbe-89ee-ca6cbb7549f0","name":"Monitor","description":"There is a simple nice monitor","creator":"mock|10101011","attributes":[{"id":"20e90cb7-0f31-4804-bb42-9122e0d670e8","attribute":{"id":"cd684b54-632f-48c2-a630-c08d70526234","code":"color","type":"string","name":"name","description":"description","value":"black"},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"a36e9f12-725a-4ed6-b2cb-0321d529ea66","attribute":{"id":"7a5b0941-43b6-41f7-baff-ad39432abb67","code":"connectivity","type":"array","name":"name","description":"description","value":null},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"ee69915a-5a4a-4399-aa28-4322da2f2c9b","attribute":{"id":"fee8f295-7b19-4d94-8245-1690ab054ad7","code":"dvi","type":"string","name":"name","description":"description","value":"true"},"parent":"7a5b0941-43b6-41f7-baff-ad39432abb67","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"c532b5e2-3eb4-4b60-9dd6-4797f7642305","attribute":{"id":"ed7257c6-50c1-499b-8900-b46d254a51ff","code":"hdmi","type":"boolean","name":"name","description":"description","value":true},"parent":"7a5b0941-43b6-41f7-baff-ad39432abb67","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"05462bb0-444d-4101-9a94-d607724b3047","attribute":{"id":"fa9c421a-dcb1-4e97-becd-c19e11d31c0c","code":"usb","type":"boolean","name":"name","description":"description","value":false},"parent":"7a5b0941-43b6-41f7-baff-ad39432abb67","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"a0e48991-64c5-4e2d-9c33-c2e9d5150bcc","attribute":{"id":"829636fe-62cc-4349-9246-de9fa94778d5","code":"year","type":"integer","name":"name","description":"description","value":2022},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"f5812d3c-c6a2-49be-b02d-c1786c93c023","attribute":{"id":"a794af18-7542-400c-8c22-740bf5b0620e","code":"manufacturer","type":"string","name":"name","description":"description","value":"LG"},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"2560f92f-5257-4b43-a5be-bc89036deb34","attribute":{"id":"6323609e-d9da-4d4d-bde0-d101edb0d51b","code":"sale","type":"boolean","name":"name","description":"description","value":false},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"2ef9ee43-898f-4004-a312-56571eeb010b","attribute":{"id":"9d0b79cb-d621-4de6-98dd-0d08000533a8","code":"recommendation","type":"boolean","name":"name","description":"description","value":true},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}],"category":"6b58caa4-0571-44db-988a-8a75f86b2520","units":[],"createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;

    public const PRODUCT_UPDATE_1 = <<<JSON
{"product":{"id":"af3de651-754b-4dbe-89ee-ca6cbb7549f0","name":"Monitor","description":"There is a simple nice monitor","creator":"mock|10101011","attributes":[{"id":"20e90cb7-0f31-4804-bb42-9122e0d670e8","attribute":{"id":"cd684b54-632f-48c2-a630-c08d70526234","code":"color","type":"string","name":"name","description":"description","value":"black"},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"a36e9f12-725a-4ed6-b2cb-0321d529ea66","attribute":{"id":"7a5b0941-43b6-41f7-baff-ad39432abb67","code":"connectivity","type":"array","name":"name","description":"description","value":null},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"ee69915a-5a4a-4399-aa28-4322da2f2c9b","attribute":{"id":"fee8f295-7b19-4d94-8245-1690ab054ad7","code":"dvi","type":"string","name":"name","description":"description","value":"true"},"parent":"7a5b0941-43b6-41f7-baff-ad39432abb67","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"c532b5e2-3eb4-4b60-9dd6-4797f7642305","attribute":{"id":"ed7257c6-50c1-499b-8900-b46d254a51ff","code":"hdmi","type":"boolean","name":"name","description":"description","value":true},"parent":"7a5b0941-43b6-41f7-baff-ad39432abb67","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"05462bb0-444d-4101-9a94-d607724b3047","attribute":{"id":"fa9c421a-dcb1-4e97-becd-c19e11d31c0c","code":"usb","type":"boolean","name":"name","description":"description","value":false},"parent":"7a5b0941-43b6-41f7-baff-ad39432abb67","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"a0e48991-64c5-4e2d-9c33-c2e9d5150bcc","attribute":{"id":"829636fe-62cc-4349-9246-de9fa94778d5","code":"year","type":"integer","name":"name","description":"description","value":2022},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"f5812d3c-c6a2-49be-b02d-c1786c93c023","attribute":{"id":"a794af18-7542-400c-8c22-740bf5b0620e","code":"manufacturer","type":"string","name":"name","description":"description","value":"LG"},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"2560f92f-5257-4b43-a5be-bc89036deb34","attribute":{"id":"6323609e-d9da-4d4d-bde0-d101edb0d51b","code":"sale","type":"boolean","name":"name","description":"description","value":false},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null},{"id":"2ef9ee43-898f-4004-a312-56571eeb010b","attribute":{"id":"9d0b79cb-d621-4de6-98dd-0d08000533a8","code":"recommendation","type":"boolean","name":"name","description":"description","value":true},"parent":"","creator":"mock|10101011","createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}],"category":"6b58caa4-0571-44db-988a-8a75f86b2520","units":["821fffe8-34d2-4cc4-81e8-089bfc7ad77a","1af0f0b6-ad6a-4315-ae4d-18e5d587865a"],"createdAt":"2022-09-01T00:00:00+00:00","updatedAt":"2022-09-01T00:00:00+00:00","deletedAt":null}}
JSON;
}
