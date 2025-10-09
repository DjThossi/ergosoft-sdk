# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
### Fixed
### Changed
### Removed

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

[unreleased]: https://github.com/DjThossi/ergosoft-sdk/compare/4.1.0...HEAD
[4.1.0]: https://github.com/DjThossi/ergosoft-sdk/releases/tag/4.1.0
[4.0.0]: https://github.com/DjThossi/ergosoft-sdk/releases/tag/4.0.0
[3.0.0]: https://github.com/DjThossi/ergosoft-sdk/releases/tag/3.0.0
[2.0.0]: https://github.com/DjThossi/ergosoft-sdk/releases/tag/2.0.0
[1.0.0]: https://github.com/DjThossi/ergosoft-sdk/releases/tag/1.0.0
