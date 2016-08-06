# portland-2030
This is the source code for the [test website](http://test.portland2030.org) of the Active 20-30 Club of Portland #122, built in PHP/CodeIgniter. Major site updates are uploaded to [the live site](http://www.portland2030.org).

* The `/_ci` directory contains the shared CodeIgniter system files used by both the production site and the test site (excluded from repository). The CI files are stored by version in their own subdirectories (e.g., `/_ci/2.1.4` contains CI v2.1.4 system files, etc.) to allow for upgrading the test site independently of the prod site. The current test site CI version is **2.2.0**. It also includes the `global.php` file, which sets sitewide constants and forces a timezone.
* The `/test` directory contains the test website files, excluding any unaltered CI application files and the `/test/uploads` directory; the latter only contains images uploaded through the website, and thus can be excluded from this repo.

Excluded root-level directories:

* The `/_uploads` directory is used for storing images uploaded through the site, shared between test and prod.
* The `/www` directory is the production version of this site.

Third party extensions/elements used:

* [Redactor](https://github.com/html5cat/redactor-js) JS WYSIWYG editor
* [Font Awesome](https://github.com/FortAwesome/Font-Awesome) icon font
* [Mono Social Icons font](http://drinchev.github.io/monosocialiconsfont/)
* [jQuery](https://jquery.com/)
* [HTML 5 Shiv](https://github.com/afarkas/html5shiv)
* [Modernizr](https://modernizr.com/)
