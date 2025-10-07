<?php
declare(strict_types=1);
namespace DjThossi\ErgosoftSdk\Domain;

/** @method Job[] getIterator() */
class JobCollection extends BaseCollection
{
    public function add(Job $element): void
    {
        $this->addUniqueElement($element->getJobGuid()->value, $element);
    }

    public function getByJobGuid(JobGuid $jobGuid): ?Job
    {
        return $this->getElement($jobGuid->value);
    }
}
