<?php
use \Mockery;
use Goutte\Client;

class UsersControllerTest extends TestCase {

    public function tearDown() {
        Mockery::close();
    }

    public function setUp() {
        parent::setUp();
        $this->mock = $this->mock('UserRepository');
        $this->goutte = new Client();
        $this->setupDatabase();
    }

    public function setupDatabase() {
        Artisan::call('migrate:install');
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
    }

    public function mock($class) {
        $mock = Mockery::mock($class);
        $this->app->instance($class, $mock);
        return $mock;
    }

    public function test_unauthenticated_logs_in() {
        $crawler = $this->client->request('GET', 'login');
        $this->assertResponseOk();
        $this->assertCount(1, $crawler->filter('label:contains("Username or Email")'));
    }

    public function test_authenticated_user_is_redirecteds() {
        $user = User::find(1);
        Auth::login($user);
        $this->client->request('GET', 'login');
        $this->assertRedirectedTo('/');
    }

    public function test_forgotten_password() {
        $crawler = $this->client->request('GET', 'forgot-password');
        $this->assertResponseOk();
        $this->assertCount(3, $crawler->filter('input'));
        $this->assertEquals('email', $crawler->filter('input')->eq(1)->attr('name'));
    }

    public function test_forgotten_password_no_user_submit() {
        $crawler = $this->client->request('GET', 'forgot-password');
        $this->assertResponseOk();
        $form = $crawler->selectButton('Continue')->form();
        $crawler = $this->goutte->submit($form);
        $this->assertCount(1, $crawler->filter('div:contains("User not found")'));
    }

    public function test_forgotten_password_submit() {
        $crawler = $this->client->request('GET', 'forgot-password');
        $this->assertResponseOk();
        $form = $crawler->selectButton('Continue')->form();
        $form['email'] = 'wazaarStudent@mailinator.com';
        $crawler = $this->goutte->submit($form);
        $this->assertCount(1, $crawler->filter('div:contains("The information regarding")'));      
    }

}
