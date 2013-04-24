<?php

/*
 * Mondrian
 */

namespace Trismegiste\Mondrian\Tests\Refactor;

use Trismegiste\Mondrian\Refactor\Contractor;
use Symfony\Component\Finder\Tests\Iterator\MockSplFileInfo;
use Symfony\Component\Finder\Tests\Iterator\MockFileListIterator;

/**
 * ContractorTest is an almost full functional test 
 * for Contractor
 */
class ContractorTest extends ContractorTestCase
{

    protected function setUp()
    {
        $cpt = 3 * $this->initStorage(array('Earth.php', 'Moon.php')); // 3 passes 
        $this->createContractorMock($cpt);
    }

    /**
     * Validates the generation of refactored classes
     */
    public function testGeneration()
    {
        $this->coder->refactor($this->storage);
        $this->compileStorage();
        $this->assertTrue(class_exists('Refact\Earth', false));
        $this->assertTrue(class_exists('Refact\Moon', false));
        $this->assertTrue(interface_exists('Refact\EarthInterface', false));
        $this->assertTrue(interface_exists('Refact\MoonInterface', false));
        // testing refactored
        $earth = new \Refact\Earth();
        $this->assertInstanceOf('Refact\EarthInterface', $earth);
        $moon = new \Refact\Moon();
        $this->assertInstanceOf('Refact\MoonInterface', $moon);
        $this->assertEquals('Fly me to the Moon', $earth->attract($moon));
        $this->assertEquals('Circling around the Earth', $moon->orbiting($earth));
    }

}