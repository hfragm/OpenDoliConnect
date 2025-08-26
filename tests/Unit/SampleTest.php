<?php
use PHPUnit\Framework\TestCase;

final class SampleTest extends TestCase {
    public function testBasicMath() {
        $this->assertEquals(4, 2 + 2);
    }
}
