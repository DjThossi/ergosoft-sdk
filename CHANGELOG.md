# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

### Fixed

### Changed

### Removed

### Breaking Changes

## [5.0.0] - 2025-10-10

### Added
- New `JobStatus` domain object for type-safe job status handling with:
  - Non-empty validation (throws `InvalidJobStatusException` for empty or whitespace-only strings)
  - `getShortVersion()` method that extracts text before the first space
- New `InvalidJobStatusException` for validation errors on job status values.
- Comprehensive unit tests for `JobStatus` covering validation and `getShortVersion()` method.
- New `GetJobsResponse` domain object providing access to status code, job collection, and response body
- New `GetJobsResponseBody` domain object extending `JsonResponseBody` for structured access to the raw JSON response.
- Comprehensive unit tests for `GetJobsResponse` and updated tests for `GetJobsApi`.
- New `GetJobByGuidResponse` domain object providing access to status code, job, and response body
- New `GetJobByGuidResponseBody` domain object extending `JsonResponseBody` for structured access to the raw JSON response.
- Comprehensive unit tests for `GetJobByGuidResponse` and updated tests for `GetJobByGuidApi`.
- New `SubmitDeltaXmlFileResponse` domain object providing access to status code, job GUID, and response body
- New `SubmitDeltaXmlFileResponseBody` domain object extending `JsonResponseBody` for structured access to the raw JSON response.
- Comprehensive unit tests for `SubmitDeltaXmlFileResponse` and updated tests for `SubmitDeltaXmlFileApi`.

### Changed
- `Job::$jobStatus` property type changed from `string` to `JobStatus` object.
- `Job::getJobStatus()` return type changed from `string` to `JobStatus` object.
- `GetJobsApi::getJobs()` now returns `GetJobsResponse` instead of `JobCollection` directly, providing access to HTTP status code and raw response body alongside the job collection.
- `GetJobByGuidApi::getJobByGuid()` now returns `GetJobByGuidResponse` instead of `Job` directly, providing access to HTTP status code and raw response body alongside the job.
- `SubmitDeltaXmlFileApi::submitDeltaXmlFile()` now returns `SubmitDeltaXmlFileResponse` instead of `JobGuid` directly, providing access to HTTP status code and raw response body alongside the job GUID.

### Breaking Changes
- `Job::getJobStatus()` now returns a `JobStatus` object instead of a string. Access the string value via `$job->getJobStatus()->value`.
- Code that directly accesses job status as a string (e.g., `$status = $job->getJobStatus()`) must be updated to use `$job->getJobStatus()->value`.
- Example migration:
  - Before: `echo $job->getJobStatus();`
  - After: `echo $job->getJobStatus()->value;`
- `GetJobsApi::getJobs()` now returns `GetJobsResponse` instead of `JobCollection`. Access the job collection via `$response->jobs`.
- Code that directly uses the result as a collection (e.g., `foreach ($api->getJobs() as $job)`) must be updated to access the `jobs` property.
- Example migration:
  - Before: `$jobs = $api->getJobs(); foreach ($jobs as $job) { ... }`
  - After: `$response = $api->getJobs(); foreach ($response->jobs as $job) { ... }`
- The `GetJobsResponse` object provides additional properties:
  - `$response->statusCode` - HTTP status code as `StatusCode` object
  - `$response->jobs` - The collection of jobs as `JobCollection` object
  - `$response->responseBody` - Raw response body as `GetJobsResponseBody` object
- `GetJobByGuidApi::getJobByGuid()` now returns `GetJobByGuidResponse` instead of `Job` directly. Access the job via `$response->job`.
- Code that directly uses the result as a Job object must be updated to access the `job` property.
- Example migration:
  - Before: `$job = $api->getJobByGuid($jobGuid); echo $job->getJobId()->value;`
  - After: `$response = $api->getJobByGuid($jobGuid); echo $response->job->getJobId()->value;`
- The `GetJobByGuidResponse` object provides additional properties:
  - `$response->statusCode` - HTTP status code as `StatusCode` object
  - `$response->job` - The job as `Job` object
  - `$response->responseBody` - Raw response body as `GetJobByGuidResponseBody` object
- `SubmitDeltaXmlFileApi::submitDeltaXmlFile()` now returns `SubmitDeltaXmlFileResponse` instead of `JobGuid` directly. Access the job GUID via `$response->jobGuid`.
- Code that directly uses the result as a JobGuid object must be updated to access the `jobGuid` property.
- Example migration:
  - Before: `$jobGuid = $api->submitDeltaXmlFile($hotFile); echo $jobGuid->value;`
  - After: `$response = $api->submitDeltaXmlFile($hotFile); echo $response->jobGuid->value;`
- The `SubmitDeltaXmlFileResponse` object provides additional properties:
  - `$response->statusCode` - HTTP status code as `StatusCode` object
  - `$response->jobGuid` - The job GUID as `JobGuid` object
  - `$response->responseBody` - Raw response body as `SubmitDeltaXmlFileResponseBody` object

## [4.2.0] - 2025-10-09

### Added
- New `JsonResponseBody` domain object extending `StringResponseBody` with JSON validation and parsing methods:
  - `isValidJson()` - validates if the response body contains valid JSON
  - `getDecodedJson()` - returns decoded JSON as an associative array
- New `TestCommunicationsApi` endpoint for testing communications via `/Trickle/test-communications` using GET method.
- New `TestCommunicationsResponse` domain object providing access to both status code and response body.
- New `TestCommunicationsResponseBody` domain object extending `JsonResponseBody` with:
    - `getMessage()` - extracts the "message" field from JSON response
- New `createTestCommunicationsApi()` factory method in `ErgosoftFactory`.
- Example file `examples/test-communications.php` demonstrating communications test with JSON helper methods.
- Comprehensive unit tests for `JsonResponseBody`, `TestCommunicationsResponseBody`, `TestCommunicationsApi` and `TestCommunicationsResponse`.
- New `UnsubscribeJobStatusApi` endpoint for unsubscribing from job status updates via `/Trickle/unsubscribe-job-status/{guid}?endpoint={endpoint}` using DELETE method.
- New `UnsubscribeJobStatusResponse` domain object providing access to both status code and response body.
- New `StringResponseBody` domain object for wrapping string response bodies (allows empty strings).
- New `createUnsubscribeJobStatusApi()` factory method in `ErgosoftFactory`.
- Example file `examples/unsubscribe-job-status.php` demonstrating job status unsubscription with response handling.
- Comprehensive unit tests for `UnsubscribeJobStatusApi` and `UnsubscribeJobStatusResponse`.
- New `SubscribeJobStatusApi` endpoint for subscribing to job status updates via `/Trickle/subscribe-job-status` using POST method with JSON request body.
- New `Endpoint` domain object with URL validation for webhook endpoints.
- New `SubscribeJobStatusResponse` domain object providing access to both status code and response body.
- New `InvalidEndpointException` for validation errors on endpoint URLs.
- New `createSubscribeJobStatusApi()` factory method in `ErgosoftFactory`.
- Example file `examples/subscribe-job-status.php` demonstrating job status subscription with request/response handling.
- Comprehensive unit tests for `SubscribeJobStatusApi`, `Endpoint`, and `SubscribeJobStatusResponse`.
- New `CancelRippingJobApi` endpoint for cancelling ripping jobs via `/Trickle/cancel-ripping-job/{guid}` using PUT method.
- New `CancelPrintingJobApi` endpoint for cancelling printing jobs via `/Trickle/cancel-printing-job/{guid}` using PUT method.
- New status code helper methods in `StatusCode`:
  - `isConflict()` - checks for 409 status code
  - `isServerError()` - checks for 500 status code
  - `isServiceUnavailable()` - checks for 503 status code
- New `put()` method in `Http\Client` for PUT requests.
- New `createCancelRippingJobApi()` factory method in `ErgosoftFactory`.
- New `createCancelPrintingJobApi()` factory method in `ErgosoftFactory`.
- Example file `examples/cancel-ripping-job.php` demonstrating ripping job cancellation with status code handling.
- Example file `examples/cancel-printing-job.php` demonstrating printing job cancellation with status code handling.
- Comprehensive unit tests for `CancelRippingJobApi`, `CancelPrintingJobApi`, new `StatusCode` methods, and `Client.put()` method.

## [4.1.0] - 2025-10-09

### Added
- New `DeleteJobApi` endpoint for deleting jobs via `/Trickle/delete-job/{guid}` using DELETE method.
- New `StatusCode` value object with helper methods for HTTP status code validation:
  - `isSuccessful()` - checks if status code is in 200-299 range
  - `isOk()` - checks for 200 status code
  - `isNoContent()` - checks for 204 status code
  - `isBadRequest()` - checks for 400 status code
  - `isForbidden()` - checks for 403 status code
  - `isNotFound()` - checks for 404 status code
- New `delete()` method in `Http\Client` for DELETE requests.
- New `createDeleteJobApi()` factory method in `ErgosoftFactory`.
- Example file `examples/delete-job.php` demonstrating job deletion with status code handling.
- Comprehensive unit tests for `DeleteJobApi`, `StatusCode`, and `Client.delete()` method.

## [4.0.0] - 2025-10-07

### Added
- New `BaseCollection` abstract class providing common collection functionality with `Countable` and `IteratorAggregate` interfaces.
- New `JobCollection` class for type-safe job collection handling, indexed by job GUID.

### Changed
- Updated examples to work with the new `JobCollection` return type.

### Breaking Changes
- `GetJobsApi::getJobs()` return type changed from `array` to `JobCollection`. This breaks existing code that:
  - Uses direct array access (e.g., `$jobs[0]`, `$jobs[1]`)
  - Passes the result to array-specific functions (e.g., `array_map()`, `array_filter()`, `array_merge()`)
  - Uses array type hints expecting `array`
- Jobs in the collection are now indexed by job GUID instead of numeric indices.
- To access jobs as an array, use `iterator_to_array($jobCollection)`.
- `count()` and `foreach` continue to work as before due to `Countable` and `IteratorAggregate` implementation.

## [3.0.0] - 2025-10-04

### Changed
- Job properties adjusted to be nullable where applicable (e.g., `jobName`, `timeCreated`, `timePrinted`, `copiesPrinted`, `printSecElapsed`, `printSecRemaining`, `copiesPrintedBefore`) and examples updated to use null-safe access.
- JobMapper now supports `timePrinted`, `timeCreated`, `jobName` as null and casts media dimensions to float where needed.
- Refined `JobId` validation logic and added tests to cover edge cases; negative values still throw `InvalidJobIdException`.

### Breaking Changes
- Job media dimensions types changed from int to float: `getMediaWidthMm()` and `getMediaLengthMm()` now return float values for improved precision.

## [2.0.0] - 2025-09-04

### Changed
- Introduced a new ErgosoftConfiguration interface requiring baseUrl and requestTimeout.
- ErgosoftFactory now requires an ErgosoftConfiguration instance instead of a base URL string.
- Http\Client now uses the dynamic requestTimeout (previously fixed).

### Breaking Changes
- Constructor signature of ErgosoftFactory changed: `__construct(ErgosoftConfiguration $configuration)`.
- Constructor signature of Http\\Client changed: `__construct(BaseUrl $baseUrl, RequestTimeout $requestTimeout)`.
- Update your code to provide an ErgosoftConfiguration implementation (e.g., SimpleErgosoftConfiguration).

### Added
- SimpleErgosoftConfiguration implementation with `baseUrl` and optional `requestTimeout` (default 10s).
- Updated examples and README to reflect the new configuration usage.

### Migration
- Instantiate with: `new SimpleErgosoftConfiguration(new BaseUrl('https://YOUR_API_URL'), new RequestTimeout(10))`.

## [1.0.0] - 2025-04-10

### Added
- Add basic structure
- Add Endpoint get-jobs
- Add Endpoint get-job-by-guid

[unreleased]: https://github.com/DjThossi/ergosoft-sdk/compare/5.0.0...HEAD
[5.0.0]: https://github.com/DjThossi/ergosoft-sdk/releases/tag/5.0.0
[4.2.0]: https://github.com/DjThossi/ergosoft-sdk/releases/tag/4.2.0
[4.1.0]: https://github.com/DjThossi/ergosoft-sdk/releases/tag/4.1.0
[4.0.0]: https://github.com/DjThossi/ergosoft-sdk/releases/tag/4.0.0
[3.0.0]: https://github.com/DjThossi/ergosoft-sdk/releases/tag/3.0.0
[2.0.0]: https://github.com/DjThossi/ergosoft-sdk/releases/tag/2.0.0
[1.0.0]: https://github.com/DjThossi/ergosoft-sdk/releases/tag/1.0.0
