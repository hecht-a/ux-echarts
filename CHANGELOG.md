# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.3.0] — 2026-02-28

### Added

#### QA tooling (`9c1a2ce`)
- PHP CS Fixer configured via `.php-cs-fixer.php` and exposed as Castor tasks (`qa:cs:check`, `qa:cs:fix`)
- PHPStan at max level configured via `phpstan.neon` and exposed as Castor task (`qa:phpstan`)

#### Stimulus controller
- `registeredThemes` set to skip redundant `echarts.registerTheme()` calls when multiple charts share the same theme (`606c107`)

### Changed

- `setAttributes()` now merges with existing attributes instead of replacing them, consistent with `setOptions()` (`9c1a2ce`)
- `dispose()` replaces `clear()` in the Stimulus controller to fully release ECharts resources (DOM listeners, canvas) on disconnect (`606c107`)
- PHPDoc types tightened: `$series` typed as `list<array<string, mixed>>`, `$attributes` as `array<string, string|bool|int|float>` (`9c1a2ce`)
- Test suite refactored: shared static kernel via `setUpBeforeClass` / `tearDownAfterClass`, coverage extended from 1 to 11 cases (`9c1a2ce`)

### Fixed

- `setWidth()` and `setHeight()` now throw `InvalidArgumentException` for zero or negative values (`c698e2f`)
- Theme registration applied to all chart instances on a page, not just the first (`606c107`)
