# portland-2030
This is the source code for the [test website](http://test.portland2030.org) of the Active 20-30 Club of Portland #122, built in PHP and CodeIgniter on the backend and JS/jQuery on the frontend, using MySQL for the database. Major site updates are uploaded to [the live site](http://www.portland2030.org) on an ad hoc basis.

## Included Directories
* `/_ci` -- The global system directory
  * Contains shared CI system files used by both test and prod sites (excluded)
    * Each CI version is stored in a separate directory (e.g., `/_ci/2.1.4` for CI v2.1.4 files) -- allows me to upgrade CI versions independently on test and prod; current CI version is **2.2.0**.
  * Contains `global.php`, which sets sitewide constants and forces a timezone in case the server's TZ isn't set properly
  * Contains `keys.php` (excluded), which stores public/private API keys for third-party libraries as constants
* `/test` -- The test website, excluding any unaltered CI app files

## Excluded Directories
* `/_uploads` -- Used for storing images uploaded through the site's admin section, shared between test and prod
* `/www` -- The production website

## Features
* Events calendar, integrated with GMaps and "add to calendar" functionality
* Contact form
* Members area
  * Behind login
  * CRUD operations for events
  * Reset password from login screen
  * Admin logging
  * Permissions system -- access to features limited per user

## Short Term To-Do
* Make "add to calendar" always add all events to calendar -- useful for tracking updates
* Add newsletter download to homepage
* Add documents section
* Update officer information for 2016-17 term
* Complete basic blog ("Flockblog" or perhaps "Flog"?) functionality
  * Add and edit blog entries with WYSIWYG editor
  * Category selection/addition
  * Cover image upload
  * Permalinks
* Add Flockblog to website
* Revamp history page
  * Add club history section -- work on writing history with someone?
  * Make wording more informal and celebratory
  * Add awards, more pins, T-shirt designs from past years
  
## Long Term To-Do
* Create page factory (library) to standardize members area view logic
* Redesign homepage to add image rotator, cinegraphs, more modern look
  * Integrate Bootstrap sitewide
  * Make mobile responsive simultaneously
* Members area updates
  * CRUD operations for member accounts, including resetting password and changing access/roles
  * Facebook events connectivity
  * Instagram integration
    * Images from past events
  * Document management
  * Read/respond to inquiries
  * Image rotator management
  * Sponsor management
  * Flockblog enhancements
    * Draft/revision tracking
    * Tags
    * Media upload
    * Link to event

## Third Party Libraries/Plugins
* [jQuery](https://jquery.com/)
  * [EasyTabs](https://os.alfajango.com/easytabs/)
  * [Featherlight](http://noelboss.github.io/featherlight/) lightbox
  * [Redactor](https://github.com/html5cat/redactor-js) JS WYSIWYG editor
  * [Tablesorter](http://tablesorter.com/docs/)
* [HTML 5 Shiv](https://github.com/afarkas/html5shiv)
* [Modernizr](https://modernizr.com/)
* [Font Awesome](https://github.com/FortAwesome/Font-Awesome) icon font
* [Mono Social Icons font](http://drinchev.github.io/monosocialiconsfont/)
