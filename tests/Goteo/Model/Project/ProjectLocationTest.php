<?php


namespace Goteo\Model\Project\Tests;

use Goteo\Model\Project\ProjectLocation;

class ProjectLocationTest extends \PHPUnit_Framework_TestCase {
    private static $data = array(
            'city' => 'Simulated City',
            'region' => 'Simulated Region',
            'country' => 'Neverland',
            'country_code' => 'XX',
            'latitude' => '0.1234567890',
            'longitude' => '-0.1234567890',
            'method' => 'ip',
            'user' => '012-simulated-project-test-210'
        );
    private static $user = array(
            'userid' => '012-simulated-project-test-210',
            'name' => 'Test user - please delete me',
            'email' => 'simulated-project-test@goteo.org'
        );
    public function testInstance() {
        \Goteo\Core\DB::cache(false);

        $location = new ProjectLocation();

        $this->assertInstanceOf('\Goteo\Model\Project\ProjectLocation', $location);

        return $location;
    }

    /**
     *
     * @depends testInstance
     */
    public function testDefaultValidation($location) {
        $this->assertFalse($location->validate());
        $this->assertFalse($location->save());
    }

    public function testAddProjectLocation() {

        $user_location = new ProjectLocation(self::$data);
        $this->assertInstanceOf('\Goteo\Model\Project\ProjectLocation', $user_location);
        $this->assertEquals($user_location->latitude, self::$data['latitude']);
        $this->assertEquals($user_location->longitude, self::$data['longitude']);
        $this->assertEquals($user_location->city, self::$data['city']);
        $this->assertEquals($user_location->region, self::$data['region']);
        $this->assertEquals($user_location->country, self::$data['country']);
        $this->assertEquals($user_location->country_code, self::$data['country_code']);
        $this->assertEquals($user_location->user, self::$data['user']);


        return $user_location;
    }
    /**
     * @depends testAddProjectLocation
     */
    public function testSaveProjectLocationNonProject($user_location) {
        // We don't care if exists or not the test user:
        if($user = \Goteo\Model\Project::get(self::$user['userid'])) {
            $user->delete();
        }

        $this->assertFalse($user_location->save());
    }

    public function testCreateProject() {
        $user = new \Goteo\Model\Project(self::$user);
        $this->assertTrue($user->save($errors, array('password')));
        $this->assertInstanceOf('\Goteo\Model\Project', $user);
    }

    /**
     * @depends testAddProjectLocation
     */
    public function testSaveProjectLocation($user_location) {
        $this->assertTrue($user_location->validate($errors), print_r($errors, 1));
        $this->assertTrue($user_location->save($errors), print_r($errors, 1));

        $user_location2 = ProjectLocation::get(self::$data['user']);

        $this->assertInstanceOf('\Goteo\Model\Project\ProjectLocation', $user_location2);
        $this->assertEquals($user_location->user, $user_location2->user);
        $this->assertEquals($user_location->longitude, $user_location2->longitude);
        $this->assertEquals($user_location->latitude, $user_location2->latitude);
        $this->assertEquals($user_location->method, $user_location2->method);

        $this->assertEquals($user_location2->latitude, self::$data['latitude']);
        $this->assertEquals($user_location2->longitude, self::$data['longitude']);
        $this->assertEquals($user_location2->city, self::$data['city']);
        $this->assertEquals($user_location2->region, self::$data['region']);
        $this->assertEquals($user_location2->country, self::$data['country']);
        $this->assertEquals($user_location2->country_code, self::$data['country_code']);
        $this->assertEquals($user_location2->user, self::$data['user']);

        return $user_location2;
    }

    /**
     * @depends  testSaveProjectLocation
     */
    public function testSetLocable($user_location) {

        $this->assertTrue($user_location::setLocable($user_location->user, $errors), print_r($errors, 1));
        $user_location2 = ProjectLocation::get($user_location->user);
        $this->assertInstanceOf('\Goteo\Model\Project\ProjectLocation', $user_location2);
        $this->assertEquals($user_location->user, $user_location2->user);
        $this->assertEquals($user_location->longitude, $user_location2->longitude);
        $this->assertEquals($user_location->latitude, $user_location2->latitude);
        $this->assertEquals($user_location->method, $user_location2->method);

        $this->assertEquals($user_location2->latitude, self::$data['latitude']);
        $this->assertEquals($user_location2->longitude, self::$data['longitude']);
        $this->assertEquals($user_location2->city, self::$data['city']);
        $this->assertEquals($user_location2->region, self::$data['region']);
        $this->assertEquals($user_location2->country, self::$data['country']);
        $this->assertEquals($user_location2->country_code, self::$data['country_code']);
        $this->assertEquals($user_location2->user, self::$data['user']);
        $this->assertFalse($user_location::isUnlocable($user_location->user));
        $this->assertTrue($user_location2->locable);
        $this->assertEquals($user_location->locations, $user_location2->locations);

        $user_location::setUnlocable($user_location->user);
        $user_location2 = ProjectLocation::get($user_location2->user);
        $this->assertTrue($user_location::isUnlocable($user_location->user));
        $this->assertFalse($user_location2->locable);

        return $user_location;
    }

    /**
     * @depends  testSetLocable
     */
    public function testSetProperty($user_location) {
        $txt = "Test info for location";
        $this->assertTrue($user_location::setProperty($user_location->user, 'info', $txt, $error), print_r($errors, 1));
        $user_location2 = ProjectLocation::get($user_location->user);
        $this->assertInstanceOf('\Goteo\Model\Project\ProjectLocation', $user_location2);
        $this->assertEquals($user_location2->info, $txt);

        return $user_location;
    }
    /**
     * @depends  testSetProperty
     */
    public function testRemoveAddLocationEntry($user_location) {

        $this->assertTrue($user_location->delete());
        $user_location2 = ProjectLocation::get($user_location->user);

        $this->assertFalse($user_location2);

    }

    /**
     * Some cleanup
     */
    static function tearDownAfterClass() {
        if($user = \Goteo\Model\Project::get(self::$user['userid'])) {
            $user->delete();
        }
    }
}
