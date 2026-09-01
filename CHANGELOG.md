# Changelog

All notable changes to Avocado CMS are documented in this file.

The format is based loosely on [Keep a Changelog](https://keepachangelog.com/), with changes grouped by release or historical development milestone.

## [Unreleased]

No changes recorded yet.

## [1.26.1] - 2026-08-31

**Podcast/Media upgrade — Build 20260831**

### Added

- Added Settings and action icons to the appropriate System widgets, including Newsletter and Podcasts.
- Added video support for podcasts.
- Added a manual force-upgrade option to Settings.
- Added support for HTML in settings where required.
- Added some new SVG icons for podcasts and settings

### Changed

- Updated the podcast RSS feed to include the podcast namespace required by the PSP-1 standard.
- Changed `Podcast_Text` settings to support HTML content instead of plain text.
- Changed `Header` setting to support HTML content instead of plain text.
- Changed `NewsDefaultMessage` to support HTML content instead of plain text.
- Changed the `DataUsage` parameter to support HTML content instead of plain text.
- Upgraded PHPMailer to 7.1.1.
- Reworked the project README and installation documentation for clarity and consistency.
- Reorganised the historical changes manifest into `CHANGELOG.md`.
- Updated third-party component documentation to reflect HTML Purifier 4.15.0 and PHPMailer 7.1.1.

### Fixed

- Fixed server-side MIME type validation for file uploads.
- Fixed missing input validation in AJAX files.
- Fixed password parameters being stored unencrypted in the session.
- Fixed password parameters potentially not being decrypted correctly when retrieved.

## [1.25.1] - 2025-08-31

### Fixed

- Fixed an installation bug that could cause an `Allowed memory size exhausted` error (issue #1).
- Fixed the Delete Podcast button.
- Fixed used parameters not being stored in the session.
- Fixed podcast URLs when Avocado is installed in a subdirectory.
- Fixed the development flag not working correctly.
- Fixed News creating links to invalid files.
- Fixed `Spam_Score_Words` being treated as a number instead of text.

### Changed

- Added a file-versus-database version check to the automatic upgrade process. This ensures that required database upgrades are performed when applying relevant fixes.

## [1.24.2] - 2024-12-08

### Added

- Added new icons and icon management.
- Added a Calendar RSS feed.
- Added the following settings:
  - `EditPodcastSecurity`
  - `SettingsSecurity`
  - `SMTPHost`
  - `SMTPPort`
  - `NewsFromUsername`
  - `NewsFromPassword`
  - `PodcastContactEmail`
  - `ContactFromEmail`
  - `ContactFromUsername`
  - `ContactFromPassword`

### Changed

- Updated the Square Menu to use colours stored in the database.
- Improved SQL injection protection.
- Added filtering of selected special characters in `target`, `section`, and `subsection` URL values.
- Updated podcast editing security.
- Updated podcasts to use `PodcastContactEmail` for the contact address when configured.
- Updated newsletters to use PHPMailer instead of PHP `mail()`.
- Updated newsletter sign-up email handling to use PHPMailer.
- Moved News storage into the database.
- Updated the Contact Us form to use PHPMailer.
- Updated user-registration email handling to use PHPMailer.

### Fixed

- Fixed an issue that could incorrectly trigger the upgrade procedure when an SQL injection attempt was detected.

## Build 20240331 Patch 2 - 2024-05-12

### Fixed

- Fixed an issue in the installation process.

## Build 20240331 - 2024-03-31

### Added

- Added the `Top_right_Menu` theme.
- Added configurable menu colours for the new theme.

### Changed

- Updated the podcast play page so that playback can be embedded alongside other content.
- Moved the site header into a configurable parameter.

### Fixed

- Fixed several minor podcast issues.
- Fixed decryption of older encrypted data.

> **Upgrade note:** Moving the site header into a parameter may remove the existing header during upgrade. Check and restore the site header after applying this update if necessary.

## [1.24.1] - 2024-01-29

### Added

- Added read-only settings.
- Added upload, send, and test parameters for newsletter email.
- Added a Duration field for podcasts and attachments.
- Added an explicit flag to Podcast parameters.
- Added a System Information page to the System menu.
- Added version and build numbers.

### Changed

- Updated front-end encryption.
- Updated database encryption.
- Updated the Calendar compact-list view.
- Updated News email handling for PHP 8.1.
- Updated the Calendar event editing page for PHP 8.1.
- Improved preservation of setting limits while editing.
- Performed minor code cleanup.

### Fixed

- Fixed several minor podcast issues.
- Fixed user-related issues.

### Removed

- Removed unused and obsolete files.

## Podcast and Calendar Updates - 2023-01-29

### Added

- Added thumbnails to Calendar entries.
- Added database storage for file attachments.
- Added a generic RSS feed page.

### Changed

- Upgraded HTML Purifier to 4.15.0.
- Confirmed operation with PHP 8.1.11.
- Updated the image-manager gallery.
- Moved podcasts into the database.
- Updated front-end encryption.

### Fixed

- Fixed new database tables not being created during an update.
- Fixed the 3 Column Menu.
- Fixed several installation issues.
- Fixed logged errors related to SSL detection on the login screen.
- Fixed sessions not being saved on non-SSL sites.

## Bug Fixes - 2022-09-17

### Fixed

- Fixed various errors identified through application logs.
- Fixed a function redeclaration error in the Contact form.
- Fixed blank articles displaying text from the previously viewed article.
- Fixed saving an article as a System page when article content is `NULL`.
- Fixed public Calendar views.
- Fixed the Target dropdown on the article editing page not showing the currently selected target.

## Vertical Menu, Article Management and System Menu

### Added

- Added a vertical menu style.
- Added dropdowns for choosing menu locations within articles.
- Added support for moving an article while editing.
- Added a dropdown for linking an article to the Calendar.
- Added the System menu.
- Added manual article sorting.

### Changed

- Moved System-related menu items from the Home menu to the new System menu.

### Fixed

- Fixed an issue displaying an article or page after updating it.

## Font Management and Editor Improvements

### Added

- Added support for custom fonts in TinyMCE editing fields.

### Changed

- Improved font management.
- Selectively removed the header from the article editing page.
- Made the TinyMCE key configurable.
- Tidied the editing page.
- Moved TinyMCE code into an include file.

## Miscellaneous Updates

### Added

- Added user-defined system fonts.

### Changed

- Updated the newsletter unsubscribe process.

## Sitemap and Calendar

### Added

- Added an automatically generated sitemap.
- Added a compact-list Calendar view.
- Added a YouTube content page.

## Spam Protection Improvements

### Added

- Added spam scoring.
- Added blocking of messages with a high spam score.
- Added blocking of repeated message retries.

## Spam Protection

### Added

- Improved Contact Us spam protection.
- Added a configurable blocked-words parameter with a default word list.

## Menu Bug Fix

### Fixed

- Fixed a menu display issue on high-resolution screens.

## Setup

### Added

- Added server and port selection during setup.

### Fixed

- Fixed the setup procedure.

## Calendar and Setup Improvements

### Added

- Added a three-month Calendar view.

### Changed

- Updated SQL server and port configuration during setup.
- Moved News update files into `System`.

### Fixed

- Fixed issues when adding and updating Calendar entries.
- Fixed newsletter subscription issues.
