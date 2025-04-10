# Ergosoft SDK

A PHP library for interacting with the Ergosoft API.

## Installation

```bash
composer require djthossi/ergosoft-sdk
```

## Usage

```php
use DjThossi\ErgosoftSdk\Factory\ErgosoftFactory;

// Initialize the factory
$factory = new ErgosoftFactory('https://YOUR-ERGOSOFT-URL');

// Get JobApi through the factory
$jobApi = $factory->getJobsApi();

// Get jobs
try {
    $jobs = $jobApi->getJobs();
    foreach ($jobs as $job) {
        echo "Job ID: " . $job->getJobId() . "\n";
        echo "Status: " . $job->getJobStatus() . "\n";
        echo "Name: " . $job->getJobName() . "\n";
        echo "Created at: " . $job->getTimeCreated()->format('Y-m-d H:i:s') . "\n";
        if ($job->getTimePrinted()) {
            echo "Printed at: " . $job->getTimePrinted()->format('Y-m-d H:i:s') . "\n";
        }
        echo "---\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
```

## Symfony Integration

Add the following configuration to your `config/services.yaml`:

```yaml
parameters:
    app.ERGOSOFT_BASE_URL: '%env(ERGOSOFT_BASE_URL)%'

services:
    DjThossi\ErgosoftSdk\Factory\ErgosoftFactory:
        arguments:
            $baseUrl: '%app.ERGOSOFT_BASE_URL%'
```

Then add to your `.env.local` file:

```env
ERGOSOFT_BASE_URL=https://YOUR-ERGOSOFT-URL
``` 