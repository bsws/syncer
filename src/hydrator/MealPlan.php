<?php
namespace Hydrator;

class MealPlan
{
    public function getInstance()
    {
        return new MealPlanGeneric();
    }
}
