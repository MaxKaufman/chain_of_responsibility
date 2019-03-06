<?php
include '../../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

class PipeTest extends TestCase
{
    /**
     * @test
     */
    public function nullOnEnd()
    {
        $lkFactory = (new Factory())->getForShop();

        $old_sub = new \Entity\Subscription(110.0, 5.5, [1, 2, 3], [55, 77, 99, 111], 1);
        $new_sub = new \Entity\Subscription(110.0, 5.5, [1, 2, 3], [55, 77, 99, 111], 1);
        $this->assertEquals(null, $lkFactory->getAlert($old_sub, $new_sub));
    }

    /**
     * @test
     */
    public function downgradePipe()
    {
        $lkFactory = (new Factory())->getForShop();
        $old_sub = new \Entity\Subscription(120.0, 5.5, [1, 2, 3], [55, 77, 99, 111], 1);
        $new_sub = new \Entity\Subscription(110.0, 5.5, [1, 2, 3], [55, 77, 99, 111], 1);

        $this->assertTrue(is_a($lkFactory->getAlert($old_sub, $new_sub), '\\Entity\\Alert'));
        $this->assertEquals('downgrade', $lkFactory->getAlert($old_sub, $new_sub)->getTemplate());
        $this->assertEquals(['delta' => -10.0], $lkFactory->getAlert($old_sub, $new_sub)->getPayload());
        $this->assertEquals(1, $lkFactory->getAlert($old_sub, $new_sub)->getType());
    }

    /**
     * @test
     */
    public function upgradePipe()
    {
        $lkFactory = (new Factory())->getForShop();

        $old_sub = new \Entity\Subscription(110.0, 5.5, [1, 2, 3], [55, 77, 99, 111], 1);
        $new_sub = new \Entity\Subscription(120.0, 5.5, [1, 2, 3], [55, 77, 99, 111], 1);

        $this->assertTrue(is_a($lkFactory->getAlert($old_sub, $new_sub), '\\Entity\\Alert'));
        $this->assertEquals('upgrade', $lkFactory->getAlert($old_sub, $new_sub)->getTemplate());
        $this->assertEquals(['delta' => 10.0], $lkFactory->getAlert($old_sub, $new_sub)->getPayload());
        $this->assertEquals(1, $lkFactory->getAlert($old_sub, $new_sub)->getType());
    }

    /**
     * @test
     */
    public function updatePipe()
    {
        $lkFactory = (new Factory())->getForLK();
        $old_sub = new \Entity\Subscription(10.0, 5.5, [1, 2, 3], [55, 77, 99, 111], 1);
        $new_sub = new \Entity\Subscription(10.0, 5.5, [1], [55, 77, 99, 111], 1);

        $this->assertTrue(is_a($lkFactory->getAlert($old_sub, $new_sub), '\\Entity\\Alert'));
        $this->assertEquals('update', $lkFactory->getAlert($old_sub, $new_sub)->getTemplate());
        $this->assertEquals([
            'bonus' => 0.0,
            'category' => $new_sub->getCategoryIds(),
            'location' => $new_sub->getLocationIds(),
            'status' => 0
        ], $lkFactory->getAlert($old_sub, $new_sub)->getPayload());
        $this->assertEquals(1, $lkFactory->getAlert($old_sub, $new_sub)->getType());
    }

    /**
     * @test
     */
    public function activatePipe()
    {
        $subFactory = (new Factory())->getForMainBanner();
        $old_sub = new \Entity\Subscription(10.0, 5.5, [1, 2, 3], [55, 77, 99, 111], 0);
        $new_sub = new \Entity\Subscription(10.0, 5.5, [1, 2, 3], [55, 77, 99, 111], 1);

        $this->assertTrue(is_a($subFactory->getAlert($old_sub, $new_sub), '\\Entity\\Alert'));
        $this->assertEquals('activate', $subFactory->getAlert($old_sub, $new_sub)->getTemplate());
        $this->assertEquals(['status' => 1], $subFactory->getAlert($old_sub, $new_sub)->getPayload());
    }

    /**
     * @test
     */
    public function closePipe()
    {
        $subFactory = (new Factory())->getForMainBanner();
        $old_sub = new \Entity\Subscription(10.0, 5.5, [1, 2, 3], [55, 77, 99, 111], 1);
        $new_sub = new \Entity\Subscription(10.0, 5.5, [1, 2, 3], [55, 77, 99, 111], 0);

        $this->assertTrue(is_a($subFactory->getAlert($old_sub, $new_sub), '\\Entity\\Alert'));
        $this->assertEquals('close', $subFactory->getAlert($old_sub, $new_sub)->getTemplate());
        $this->assertEquals(['status' => 0], $subFactory->getAlert($old_sub, $new_sub)->getPayload());
    }
}
