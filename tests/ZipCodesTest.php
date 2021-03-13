<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use RauweBieten\ZipCodes\ZipCodes;

class ZipCodesTest extends TestCase
{
    public function supportedCountriesProvider(): array
    {
        return [
            ['BE'],
            ['DE'],
            ['ES'],
            ['FR'],
            ['IT'],
            ['LU'],
            ['NL'],
        ];
    }

    public function testValidCountryCode(): void
    {
        $data = \RauweBieten\ZipCodes\ZipCodes::getData('BE');
        $this->assertIsArray($data, 'Data should be an array');
    }

    public function testInvalidCountryCode(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Country XXX not supported');
        ZipCodes::getData('XXX');
    }

    /**
     * @param string $countryCode
     * @dataProvider supportedCountriesProvider
     */
    public function testDataIsArrayOfArrays(string $countryCode): void
    {
        $data = \RauweBieten\ZipCodes\ZipCodes::getData($countryCode);
        $this->assertIsArray($data, 'Data should be an array');
        $this->assertIsArray($data[0], 'Child elements should be arrays');
    }

    /**
     * @param string $countryCode
     * @dataProvider supportedCountriesProvider
     */
    public function testArrayElements(string $countryCode): void
    {
        $data = ZipCodes::getData($countryCode);
        $element = $data[0];

        $this->assertArrayHasKey('country', $element, 'Element has country key');
        $this->assertEquals($countryCode, $element['country'], 'Country should be ' . $countryCode);

        $this->assertArrayHasKey('place', $element, 'Element has place key');
        $this->assertIsString($element['place'], 'Place should be a string');

        $this->assertArrayHasKey('zipcode', $element, 'Element has zipcode key');
        $this->assertIsString($element['place'], 'Place should be a string');

        $this->assertArrayHasKey('latitude', $element, 'Element has latitude key');
        $this->assertIsString($element['latitude'], 'Latitude should be a string');
        $this->assertMatchesRegularExpression('/^-?\d+\.\d+$/', $element['latitude'], 'Latitude should be a float in a string');

        $this->assertArrayHasKey('longitude', $element, 'Element has longitude key');
        $this->assertIsString($element['longitude'], 'Place should be a string');
        $this->assertMatchesRegularExpression('/^-?\d+\.\d+$/', $element['longitude'], 'Longitude should be a float in a string');
    }
}