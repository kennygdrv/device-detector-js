<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

require __DIR__ . '/../vendor/autoload.php';

class DeviceDetectorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider getFixtures
     */
    public function testParse($fixtureData)
    {
        $ua = $fixtureData['user_agent'];
        $uaInfo = DeviceDetector::getInfoFromUserAgent($ua);
        $this->assertEquals($fixtureData, $uaInfo);
    }

    public function getFixtures()
    {
        $fixturesPath = realpath(dirname(__FILE__) . '/DeviceDetectorFixtures.yml');
        $fixtures = Spyc::YAMLLoad($fixturesPath);
        return array_map(function($elem) {return array($elem);}, $fixtures);
    }

    /**
     * @dataProvider getAllOs
     */
    public function testOSInGroup($os)
    {
        $familyOs = call_user_func_array('array_merge', DeviceDetector::$osFamilies);
        $this->assertContains($os, $familyOs);
    }

    public function getAllOs()
    {
        $allOs = array_keys(DeviceDetector::$operatingSystems);
        $allOs = array_map(function($os){ return array($os); }, $allOs);
        return $allOs;
    }
}