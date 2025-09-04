# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
### Fixed
### Changed
### Removed

## [2.0.0] - 2025-09-04

### Changed
- Introduced new Configuration interface requiring baseUrl and requestTimeout.
- ErgosoftFactory now requires a Configuration instance instead of a base URL string.
- Http\Client now uses the dynamic requestTimeout from Configuration (previously fixed).

### Breaking Changes
- Constructor signature of ErgosoftFactory changed: `__construct(Configuration $configuration)`.
- Constructor signature of Http\\Client changed: `__construct(Configuration $configuration)`.
- Update your code to provide a Configuration implementation (e.g., SimpleConfiguration).

### Added
- SimpleConfiguration implementation with `baseUrl` and optional `requestTimeout` (default 10s).
- Updated examples and README to reflect the new configuration usage.

### Migration
- Instantiate with: `new SimpleConfiguration(new BaseUrl('https://YOUR_API_URL'), new RequestTimeout(10))`.

## [1.0.0] - 2025-04-10

### Added
- Add basic structure
- Add Endpoint get-jobs
- Add Endpoint get-job-by-guid

[unreleased]: https://github.com/DjThossi/ergosoft-sdk/compare/2.0.0...HEAD
[2.0.0]: https://github.com/DjThossi/ergosoft-sdk/releases/tag/2.0.0
[1.0.0]: https://github.com/DjThossi/ergosoft-sdk/releases/tag/1.0.0
