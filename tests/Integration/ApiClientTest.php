<?php
use PHPUnit\Framework\TestCase;
use ODC\Integration\Dolibarr\Client;

final class ApiClientTest extends TestCase {
    public function testClientInitialization() {
        $client = new Client('https://example.com/api/index.php', 'FAKE_TOKEN');
        $this->assertInstanceOf(Client::class, $client);
    }
}
