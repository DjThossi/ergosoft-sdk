# Ergosoft SDK

A PHP library for interacting with the Ergosoft Delta Automation API.

This library is supporting the following endpoints at the moment

- /Trickle/cancel-printing-job
- /Trickle/cancel-ripping-job
- /Trickle/delete-job
- /Trickle/get-job-by-guid
- /Trickle/get-jobs
- /Trickle/move-up-job-position-in-queue
- /Trickle/submit-delta-xml-file
- /Trickle/subscribe-job-status
- /Trickle/test-communications
- /Trickle/unsubscribe-job-status

This library is made for PHP projects featuring PHP version 8.4+.

## Installation

```bash
composer require djthossi/ergosoft-sdk
```

## Usage

```php
use DjThossi\ErgosoftSdk\ErgosoftFactory;
use DjThossi\ErgosoftSdk\SimpleErgosoftConfiguration;
use DjThossi\ErgosoftSdk\Domain\BaseUrl;

// Initialize the Ergosoft API client with YOUR URL and optional timeout (defaults to 10s)
$configuration = new SimpleErgosoftConfiguration(new BaseUrl('https://YOUR_API_URL'));
$factory = new ErgosoftFactory($configuration);
$jobApi = $factory->createGetJobsApi();

try {
    $jobs = $jobApi->getJobs();
    foreach ($jobs as $job) {
        echo "Job ID: " . $job->getJobId()->value . "\n";
        echo "Status: " . $job->getJobStatus() . "\n";
        echo "Name: " . $job->getJobName()->value . "\n";
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
You want to use this library inside a symfony project including auto-wiring? After installing simply add this to your code.

Add this to the parameter section of your `services.yaml`
```yaml
parameters:
  # shipcloud parameters
  app.ERGOSOFT_BASE_URL: "%env(ERGOSOFT_BASE_URL)%"
```

Add this to the services section of your `services.yaml`
```yaml
services:
  # ergosoft-sdk services
    DjThossi\ErgosoftSdk\Http\:
        resource: '../vendor/djthossi/ergosoft-sdk/src/Http'
        bind:
            $apiKey: '%app.ERGOSOFT_BASE_URL%'

    DjThossi\ErgosoftSdk\Api\:
        resource: '../vendor/djthossi/ergosoft-sdk/src/Api'
        arguments:
            $client: '@DjThossi\ErgosoftSdk\Http\Client'
```

Afterward add the `ERGOSOFT_BASE_URL` including your personal Ergosoft URL to your `.env.local` file like this.
```apacheconf
#shipcloud parameters
ERGOSOFT_BASE_URL=http://192.168.1.2
```

Now you can use each API Endpoint directly inside your business logic. Symfony will take care of the auto-wiring for you.
```php
<?php
declare(strict_types=1);
namespace App\Controller;

use DjThossi\ErgosoftSdk\Api\GetJobsApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function index(GetJobsApi $getJobsApi): Response {
        var_dump($getJobsApi->getJobs());

        //...
    }
}
```

## Contribute to this repo
For more details click [here](CONTRIBUTING.md)
