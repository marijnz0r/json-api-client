<?php

namespace Swis\JsonApi\Client\Tests\Items;

use Swis\JsonApi\Client\Items\JenssegersItem;
use Swis\JsonApi\Client\Tests\AbstractTest;
use Swis\JsonApi\Client\Tests\Mocks\Items\Jenssegers\WithGetMutatorJenssegersItem;
use Swis\JsonApi\Client\Tests\Mocks\Items\Jenssegers\WithHiddenJenssegersItem;

class JenssegersItemTest extends AbstractTest
{
    protected $attributes;

    /**
     * ItemTest constructor.
     */
    public function __construct()
    {
        $this->attributes = ['testKey' => 'testValue'];

        parent::__construct();
    }

    /**
     * @test
     */
    public function it_can_instantiate_an_item()
    {
        $item = new JenssegersItem();
        $this->assertInstanceOf(JenssegersItem::class, $item);
    }

    /**
     * @test
     */
    public function is_shows_type_and_id_and_attributes_in_to_json_api_array()
    {
        $item = new JenssegersItem($this->attributes);
        $item->setType('testType');
        $item->setId(1234);

        $this->assertEquals(
            [
                'type'       => 'testType',
                'id'         => 1234,
                'attributes' => $this->attributes,
            ],
            $item->toJsonApiArray()
        );
    }

    /**
     * @test
     */
    public function it_gets_and_sets_type()
    {
        $item = new JenssegersItem();
        $item->setType('testType');

        $this->assertEquals('testType', $item->getType());
    }

    /**
     * @test
     */
    public function it_is_new_when_no_id_isset()
    {
        $item = new JenssegersItem();
        $item->setType('testType');
        $item->setId(1);

        $this->assertFalse($item->isNew());
        $item->setId(null);
        $this->assertTrue($item->isNew());
    }

    /**
     * @test
     */
    public function it_returns_has_id_when_id_isset()
    {
        $item = new JenssegersItem();
        $item->setType('testType');
        $this->assertFalse($item->hasId());

        $item->setId(1);
        $this->assertTrue($item->hasId());
    }

    /**
     * @test
     */
    public function it_returns_id_when_id_isset()
    {
        $item = new JenssegersItem();

        $item->setId(1234);
        $this->assertEquals(1234, $item->getId());
    }

    /**
     * @test
     */
    public function it_returns_attributes()
    {
        $item = new JenssegersItem($this->attributes);
        $this->assertEquals($this->attributes, $item->getAttributes());
    }

    /**
     * @test
     */
    public function it_returns_attribute_from_get_mutator()
    {
        $item = new WithGetMutatorJenssegersItem();

        $this->assertEquals('test', $item->getAttribute('test_attribute'));
    }

    /**
     * @test
     */
    public function it_sets_initial_values()
    {
        $item = new JenssegersItem();
        $response = $item->setInitial(['testKey' => 'testValue']);

        $this->assertEquals($item, $response);
        $this->assertEquals(['testKey' => 'testValue'], $item->getInitial());
    }

    /**
     * @test
     */
    public function it_uses_initial_values()
    {
        $itemBuilder = new JenssegersItem();
        $itemBuilder->fill(['testKey' => 1, 'anotherTestKey' => 'someValue']);
        $itemBuilder->setInitial(['testKey' => 9999]);
        $itemBuilder->useInitial();

        $this->assertEquals(['testKey' => 9999, 'anotherTestKey' => 'someValue'], $itemBuilder->getAttributes());
    }

    /**
     * @test
     */
    public function it_adds_unknown_relationships_in_snake_case()
    {
        $item = new JenssegersItem();
        $item->setRelation('someRelation', (new JenssegersItem())->setType('type')->setId(1));

        $this->assertTrue($item->hasRelationship('some_relation'));
    }

    /**
     * @test
     */
    public function is_does_not_show_attributes_in_to_json_api_array_when_it_has_no_attributes()
    {
        $item = new WithHiddenJenssegersItem($this->attributes);
        $item->setType('testType');
        $item->setId(1234);

        $this->assertEquals(
            [
                'type' => 'testType',
                'id'   => 1234,
            ],
            $item->toJsonApiArray()
        );
    }
}
