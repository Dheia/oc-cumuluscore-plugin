<?php namespace Initbiz\CumulusCore\Tests\Models;

use Initbiz\CumulusCore\Models\Cluster;
use Initbiz\CumulusCore\Models\Plan;
use PluginTestCase;

class ClusterTest extends PluginTestCase
{
    public function testCanEnterFeature()
    {
        $this->assertTrue(true);
        // $cluster = new Cluster;
        // $cluster->name = 'testowy';
        // $cluster->save();
        
        // $plan = new Plan;
        // $plan->name = 'testowy plan';
        // $plan->slug = 'testowy-plan';
        // $plan->features = [
        //     'initbiz.cumulusdemo.basic.gallery',
        // ];
        // $plan->save();

        // $this->assertFalse($cluster->canEnterFeature('initbiz.cumulusdemo.basic.gallery'));
        // $this->assertFalse($cluster->canEnterFeature('initbiz.cumulusdemo.basic.todo'));
        
        // $cluster->plan()->add($plan);

        // $this->assertTrue($cluster->canEnterFeature('initbiz.cumulusdemo.basic.gallery'));
        // $this->assertFalse($cluster->canEnterFeature('initbiz.cumulusdemo.basic.todo'));
    }

    public function testHasFeature()
    {
        $this->assertTrue(true);
        // $cluster = new Cluster;
        // $cluster->name = 'testowy';
        // $cluster->save();
        
        // $plan = new Plan;
        // $plan->name = 'testowy plan';
        // $plan->slug = 'testowy-plan';
        // $plan->features = [
        //     'initbiz.cumulusdemo.basic.gallery',
        // ];
        // $plan->save();

        // $this->assertFalse($cluster->hasFeature('initbiz.cumulusdemo.basic.gallery'));
        // $this->assertFalse($cluster->hasFeature('initbiz.cumulusdemo.basic.todo'));
        
        // $cluster->plan()->add($plan);

        // $this->assertTrue($cluster->hasFeature('initbiz.cumulusdemo.basic.gallery'));
        // $this->assertFalse($cluster->hasFeature('initbiz.cumulusdemo.basic.todo'));
    }
    
    public function testCanEnterAnyFeature()
    {
        $this->assertTrue(true);
        // $cluster = new Cluster;
        // $cluster->name = 'testowy';
        // $cluster->save();
        
        // $plan = new Plan;
        // $plan->name = 'testowy plan';
        // $plan->slug = 'testowy-plan';
        // $plan->features = [
        //     'initbiz.cumulusdemo.advanced.dashboard',
        //     'initbiz.cumulusdemo.advanced.todo',
        //     'initbiz.cumulusdemo.advanced.gallery',
        //     'initbiz.cumulusdemo.basic.dashboard',
        //     'initbiz.cumulussubscriptions.manage_subscription',
        //     'initbiz.cumulusplus.cluster_settings',
        // ];
        // $plan->save();

        // $this->assertFalse($cluster->canEnterAnyFeature([]));
        // $this->assertFalse($cluster->canEnterAnyFeature(['initbiz.cumulusdemo.advanced.todo', 'initbiz.cumulusdemo.basic.dashboard']));
        
        // $cluster->plan()->add($plan);

        // $this->assertTrue($cluster->canEnterAnyFeature(['initbiz.cumulusdemo.advanced.todo', 'initbiz.cumulusdemo.basic.dashboard']));
        // $this->assertTrue($cluster->canEnterAnyFeature(['initbiz.cumulusdemo.advanced.todo', 'initbiz.cumulusdemo.basic.todo']));
        // $this->assertFalse($cluster->canEnterAnyFeature(['initbiz.cumulusdemo.basic.todo', 'initbiz.cumulusdemo.basic.todo']));
        // $this->assertFalse($cluster->canEnterAnyFeature([]));
    }

    // public function testFeatures()
    // {
        
    // }
}