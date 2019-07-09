<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests\Support;

use Rugaard\DMI\Tests\AbstractTestCase;
use Tightenco\Collect\Support\Collection;

/**
 * Class MeasurementsTest.
 *
 * @package Rugaard\DMI\Tests\Support
 */
class MeasurementsTest extends AbstractTestCase
{
    /**
     * Test getMeasurementParameters().
     *
     * @return void
     */
    public function testGetMeasurementParameters() : void
    {
        // Mocked test data.
        $mockedData = Collection::make([
            'temperature' => Collection::make(['id' => 101, 'name' => 'Middeltemperatur', 'title' => 'Middeltemperatur']),
            'temperature-max' => Collection::make(['id' => 112, 'name' => 'Maksimumtemperatur', 'title' => 'Maksimumtemperatur']),
            'temperature-min' => Collection::make(['id' => 122, 'name' => 'Minimumtemperatur', 'title' => 'Minimumtemperatur']),
            'humidity' => Collection::make(['id' => 201, 'name' => 'Luftfugtighed', 'title' => 'Middel relativ luftfugtighed']),
            'pressure' => Collection::make(['id' => 401, 'name' => 'Lufttryk', 'title' => 'Lufttryk']),
            'wind' => Collection::make(['id' => 301, 'name' => 'Middelvind', 'title' => 'Middelvindhastighed']),
            'wind-max' => Collection::make(['id' => 302, 'name' => 'Højeste middelvind', 'title' => 'Højeste middelvind']),
            'wind-gust' => Collection::make(['id' => 305, 'name' => 'Vindstød', 'title' => 'Højeste vindstød']),
            'wind-direction' => Collection::make(['id' => 371, 'name' => 'Vindretning', 'title' => 'Middel vindretning']),
            'precipitation' => Collection::make(['id' => 601, 'name' => 'Nedbør', 'title' => 'Summeret nedbør']),
            'precipitation-corrected' => Collection::make(['id' => 621, 'name' => 'Nedbør korrigeret', 'title' => 'Korrigeret summeret nedbør']),
            'precipitation-intensity' => Collection::make(['id' => 633, 'name' => 'Nedbørintensitet', 'title' => 'Højeste nedbørsintensitet']),
            'sun' => Collection::make(['id' => 504, 'name' => 'Sol', 'title' => 'Summeret solskin']),
            'drought' => Collection::make(['id' => 212, 'name' => 'Tørkeindeks', 'title' => 'Tørkeindeks']),
            'lightning' => Collection::make(['id' => 680, 'name' => 'Lyn', 'title' => 'Lynnedslag']),
            'snow' => Collection::make(['id' => 906, 'name' => 'Snedybde', 'title' => 'Snedybde']),
        ]);

        // Get measurement parameters.
        $measurementParameters = getMeasurementParameters();

        // Test that measured parameters is a Collection.
        $this->assertInstanceOf(Collection::class, $measurementParameters);

        // Assert each measurement parameters ID and name.
        $mockedData->each(function ($data, $key) use ($measurementParameters) {
            // Get current parameter.
            $currentParameter = $measurementParameters->get($key);

            // Assertions.
            $this->assertIsInt($currentParameter->get('id'));
            $this->assertEquals($data->get('id'), $currentParameter->get('id'));
            $this->assertIsString($currentParameter->get('name'));
            $this->assertEquals($data->get('name'), $currentParameter->get('name'));
            $this->assertIsString($currentParameter->get('title'));
            $this->assertEquals($data->get('title'), $currentParameter->get('title'));
        });
    }

    /**
     * Test testGetMeasurementParameterByKey().
     *
     * @return void
     */
    public function testGetMeasurementParameterByKey() : void
    {
        getMeasurementParameters()->each(function ($data, $parameterKey) {
            // Get parameter by key.
            $parameter = getMeasurementParameterByKey($parameterKey);

            // Assertions.
            $this->assertInstanceOf(Collection::class, $parameter);
            $this->assertIsInt($parameter->get('id'));
            $this->assertEquals($data->get('id'), $parameter->get('id'));
            $this->assertIsString($parameter->get('name'));
            $this->assertEquals($data->get('name'), $parameter->get('name'));
            $this->assertIsString($parameter->get('title'));
            $this->assertEquals($data->get('title'), $parameter->get('title'));
        });
    }
}